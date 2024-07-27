#!/bin/bash
BACKUP_DIR=/srv/xanadu/backup

cd /var/lib
tar -czv $BACKUP_DIR/jellyfin.tar.gz jellyfin
cd /etc
tar -czv $BACKUP_DIR/jellyfin-conf.tar.gz jellyfin
 
cd "/var/lib/plexmediaserver/Library/Application Support"
tar -czvf $BACKUP_DIR/plex.tar.gz \
--exclude="Plex Media Server/Logs" \
--exclude="Plex Media Server/Cache" \
"Plex Media Server"
