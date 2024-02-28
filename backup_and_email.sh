#!/bin/bash

# MySQL Database Details
DB_USER="root"
DB_PASSWORD="CBi@1234"
DB_NAME="CBi"

# Backup Directory
BACKUP_DIR="/var/www/html/Backup"

# Date for the backup file
DATE=$(date +"%Y%m%d%H%M%S")

# MySQL Dump
mysqldump -u$DB_USER -p$DB_PASSWORD $DB_NAME > $BACKUP_DIR/backup_$DATE.sql

# Compress the backup file
gzip $BACKUP_DIR/backup_$DATE.sql

# Email Configuration
TO_EMAIL="cbielectricsms@gmail.com"
FROM_EMAIL="stockmanagement@cbi-electric.com.au"
SUBJECT="MySQL Database Backup"
BODY="Attached is the backup of the MySQL database."

# SMTP Server Details
SMTP_SERVER="smtp.office365.com"
SMTP_PORT="587"
SMTP_USER="stockmanagement@cbi-electric.com.au"
SMTP_PASSWORD="BNWijFm3wY1qPZvy"

# Email the backup file using mutt
/usr/bin/mutt -s "$SUBJECT" -a $BACKUP_DIR/backup_$DATE.sql.gz -- $TO_EMAIL <<EOF
$BODY
EOF
