/*
** Copyright 2000-2001 Double Precision, Inc.
** See COPYING for distribution information.
*/

#include	"config.h"
#include	"soxwrap.h"
#include	<stdlib.h>

static const char rcsid[]="$Id: testprog.c,v 1.1.1.1 2003/05/07 02:14:31 lfan Exp $";

int main(int argc, char **argv)
{
int	fd=sox_socket(PF_INET, SOCK_STREAM, 0);
struct	sockaddr addr;
socklen_t	addr_len;

	if (fd < 0)
	{
		perror("socket");
		exit(1);
	}

	addr_len=sizeof(addr);

	if (sox_getsockname(fd, &addr, &addr_len))
	{
		perror("getsockname");
		exit(1);
	}

	sox_close(fd);
	exit(0);
	return (0);
}
