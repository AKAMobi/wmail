#ifndef	numlib_h
#define	numlib_h

/*
** Copyright 1998 - 2003 Double Precision, Inc.
** See COPYING for distribution information.
*/

#ifdef	__cplusplus
extern "C" {
#endif

static const char numlib_h_rcsid[]="$Id: numlib.h,v 1.1.1.1 2003/05/07 02:13:08 lfan Exp $";

#if	HAVE_CONFIG_H
#include	"../numlib/config.h" /* VPATH build */
#endif

#include	<sys/types.h>
#include	<time.h>

#define	NUMBUFSIZE	60

/* Convert various system types to decimal */

char	*libmail_str_time_t(time_t, char *);
char	*libmail_str_off_t(off_t, char *);
char	*libmail_str_pid_t(pid_t, char *);
char	*libmail_str_dev_t(dev_t, char *);
char	*libmail_str_ino_t(ino_t, char *);
char	*libmail_str_uid_t(uid_t, char *);
char	*libmail_str_gid_t(gid_t, char *);
char	*libmail_str_size_t(size_t, char *);

char	*libmail_str_sizekb(unsigned long, char *);	/* X Kb or X Mb */

/* Convert selected system types to hex */

char	*libmail_strh_time_t(time_t, char *);
char	*libmail_strh_pid_t(pid_t, char *);
char	*libmail_strh_ino_t(ino_t, char *);
char	*libmail_strh_dev_t(dev_t, char *);

/*
** The following functions are used by root to reset its user and group id
** to the authenticated user's.  Various functions are provided to handle
** various situations.
*/

void libmail_changegroup(gid_t);	/* Set the group id only.  Also clear any
				** auxiliary group ids */

void libmail_changeuidgid(uid_t, gid_t);
				/* Set both user id and group id.  Also clear
				** aux group ids */

void libmail_changeusername(const char *, const gid_t *);
	/*
	** Set the userid to the indicate user's.  If second argument is
	** not null, it points to the groupid to set.  If it's null, the
	** group id is taken from the passwd file.  Auxiliary IDs are set
	** to any aux IDs set for the user in the group file.  If there are
	** no aux group IDs for the user, any AUX ids are cleared.
	*/

#ifdef	__cplusplus
}
#endif
#endif
