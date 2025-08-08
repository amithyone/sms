#!/bin/bash

# Setup Cron Job for Log Rotation
# This script sets up automatic log cleanup via cron

CRON_JOB="0 2 * * * cd /Users/amiithyone/Documents/faddedsms && ./log-cleanup.sh >> storage/logs/cron.log 2>&1"

echo "Setting up automatic log rotation..."
echo "Cron job will run daily at 2:00 AM"

# Check if cron job already exists
if crontab -l 2>/dev/null | grep -q "log-cleanup.sh"; then
    echo "Cron job already exists. Removing old entry..."
    crontab -l 2>/dev/null | grep -v "log-cleanup.sh" | crontab -
fi

# Add new cron job
(crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -

echo "Cron job added successfully!"
echo "Current cron jobs:"
crontab -l

echo ""
echo "Log rotation will now run automatically every day at 2:00 AM"
echo "You can manually run the cleanup script anytime with: ./log-cleanup.sh" 