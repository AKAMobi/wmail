# Copyright 2000-2002 Double Precision, Inc.
# See COPYING for distribution information.
#
# $Id: mkibm864.pl,v 1.1.1.1 2003/05/07 02:13:56 lfan Exp $
#
# Generate iso-8859* unicode tables

my $set=shift;

open (U, "UnicodeData.txt") || die "$!\n";

while (<U>)
{
	chomp;

my @fields= split /;/;

my ($code, $uc, $lc, $tc);

	$code="0x$fields[0]";
	eval "\$code=$code;";

	$uc=$fields[12];
	if ($uc ne "")
	{
		eval "\$uc=0x$uc;";
		$UC{$code}=$uc;
	}

	$lc=$fields[13];
	if ($lc ne "")
	{
		eval "\$lc=0x$lc;";
		$LC{$code}=$lc;
	}

	$tc=$fields[14];
	if ($tc ne "")
	{
		eval "\$tc=0x$tc;";
		$TC{$code}=$tc;
	}
}

close(U);

my @fwd;

my $rev;

open (SET, $set) || die "$set: $!\n";
while (<SET>)
{
	chomp;
	s/\#.*//;

my ($code, $unicode)=split /[ \t]+/;

	next unless $code ne "";

	eval "\$code=$code;";
	eval "\$unicode=$unicode;";

	die if $code < 0 || $code > 255;

	$fwd[$code]=$unicode;
	$rev{$unicode}=$code;
}
close(SET);

my $fwdname=shift;

print '
/*
** Copyright 2000-2002 Double Precision, Inc.
** See COPYING for distribution information.
**
** $Id: mkibm864.pl,v 1.1.1.1 2003/05/07 02:13:56 lfan Exp $
*/

#include "unicode.h"
';


print "static const unicode_char $fwdname [256]={\n";

for ($i=0; $i<256; $i++)
{
my $n=$fwd[$i];

	$n=0 unless $n;

	print "$n";
	print "," if $i < 255;
	print "\n" if ($i % 16) == 15;
}

print "};\n";

my $ucname=shift;

print "static const char $ucname [256]={\n";

for ($i=0; $i<256; $i++)
{
my $unicode=$fwd[$i];

	$unicode=$UC{$unicode} && $rev{$UC{$unicode}} ? $rev{$UC{$unicode}}:$i;

	printf("(char)0x%02x", $unicode);
	print "," if $i < 255;
	print "\n" if ($i % 8) == 7;
}

print "};\n";

my $lcname=shift;

print "static const char $lcname [256]={\n";

for ($i=0; $i<256; $i++)
{
my $unicode=$fwd[$i];

	$unicode=$LC{$unicode} && $rev{$LC{$unicode}} ? $rev{$LC{$unicode}}:$i;

	printf("(char)0x%02x", $unicode);
	print "," if $i < 255;
	print "\n" if ($i % 8) == 7;
}

print "};\n";

my $tcname=shift;

print "static const char $tcname [256]={\n";

for ($i=0; $i<256; $i++)
{
my $unicode=$fwd[$i];

	$unicode=$TC{$unicode} && $rev{$TC{$unicode}} ? $rev{$TC{$unicode}}:$i;

	printf("(char)0x%02x", $unicode);
	print "," if $i < 255;
	print "\n" if ($i % 8) == 7;
}

my $structname=shift;
my $chsetname=shift;

print "};


static unicode_char *c2u(const struct unicode_info *u, const char *cp, int *ip)
{
	return (unicode_ibm864_c2u(cp, ip, $fwdname));
}

static char *u2c(const struct unicode_info *u, const unicode_char *cp, int *ip)
{
	return (unicode_ibm864_u2c(cp, ip, $fwdname));
}

static char *toupper_func(const struct unicode_info *u, const char *cp, int *ip)
{
	return (unicode_iso8859_convert(cp, ip, $ucname));
}

static char *tolower_func(const struct unicode_info *u, const char *cp, int *ip)
{
	return (unicode_iso8859_convert(cp, ip, $lcname));
}

static char *totitle_func(const struct unicode_info *u, const char *cp, int *ip)
{
	return (unicode_iso8859_convert(cp, ip, $tcname));
}

const struct unicode_info $structname = {
	\"$chsetname\",
	0,
	c2u,
	u2c,
	toupper_func,
	tolower_func,
	totitle_func};
";
