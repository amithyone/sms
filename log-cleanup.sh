#!/bin/bash

# Log Cleanup Script for FaddedSMS
# This script manages log files to prevent them from growing too large

LOG_DIR="storage/logs"
BACKUP_DIR="storage/logs/backups"
MAX_LOG_SIZE="10M"  # Maximum log file size
KEEP_DAYS=7        # Keep logs for 7 days

echo "Starting log cleanup at $(date)"

# Create backup directory if it doesn't exist
mkdir -p "$BACKUP_DIR"

# Function to compress and move old logs
cleanup_old_logs() {
    echo "Cleaning up old log files..."
    
    # Find and compress log files older than 1 day
    find "$LOG_DIR" -name "laravel-*.log" -mtime +1 -exec gzip {} \;
    
    # Move compressed logs to backup directory
    find "$LOG_DIR" -name "laravel-*.log.gz" -exec mv {} "$BACKUP_DIR/" \;
    
    # Remove logs older than KEEP_DAYS
    find "$BACKUP_DIR" -name "*.log.gz" -mtime +$KEEP_DAYS -delete
    
    echo "Old log cleanup completed"
}

# Function to truncate large current log
truncate_large_log() {
    echo "Checking for large log files..."
    
    if [ -f "$LOG_DIR/laravel.log" ]; then
        LOG_SIZE=$(du -h "$LOG_DIR/laravel.log" | cut -f1)
        echo "Current log size: $LOG_SIZE"
        
        # If log is larger than MAX_LOG_SIZE, truncate it (10MB = 10485760 bytes)
        LOG_SIZE_BYTES=$(stat -f%z "$LOG_DIR/laravel.log" 2>/dev/null || stat -c%s "$LOG_DIR/laravel.log" 2>/dev/null)
        MAX_SIZE_BYTES=10485760  # 10MB in bytes
        if [ "$LOG_SIZE_BYTES" -gt "$MAX_SIZE_BYTES" ]; then
            echo "Log file is too large, truncating..."
            cp "$LOG_DIR/laravel.log" "$BACKUP_DIR/laravel-$(date +%Y%m%d-%H%M%S).log"
            echo "" > "$LOG_DIR/laravel.log"
            echo "Log file truncated"
        fi
    fi
}

# Function to show log statistics
show_log_stats() {
    echo "=== Log Statistics ==="
    echo "Current log size: $(du -h "$LOG_DIR/laravel.log" 2>/dev/null || echo 'N/A')"
    echo "Backup directory size: $(du -sh "$BACKUP_DIR" 2>/dev/null || echo 'N/A')"
    echo "Number of backup files: $(find "$BACKUP_DIR" -name "*.log*" 2>/dev/null | wc -l)"
    echo "====================="
}

# Main execution
cleanup_old_logs
truncate_large_log
show_log_stats

echo "Log cleanup completed at $(date)" 