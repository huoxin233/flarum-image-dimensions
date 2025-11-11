# Debug Cron Issues

## Check if cron is running

```bash
# Check crontab
sudo crontab -u www-nobody -l

# Should see:
* * * * * cd /usr/local/servers/zabytki.in.ua/flarum-dev && php flarum schedule:run >> /dev/null 2>&1
```

## Add logging to debug

Edit crontab:
```bash
sudo crontab -u www-nobody -e
```

Change line to:
```
* * * * * cd /usr/local/servers/zabytki.in.ua/flarum-dev && php flarum schedule:run >> /tmp/flarum-schedule.log 2>&1
```

Then check log:
```bash
tail -f /tmp/flarum-schedule.log
```

## Test manually

```bash
# Run as www-nobody
sudo -u www-nobody php flarum schedule:run -v

# Should show what tasks ran
```

## Check if scheduled check is enabled

```bash
php flarum schedule:list
```

Should show your frequency (daily/weekly/monthly), not `* * * * *`

## Verify settings in admin panel

- Enable Scheduled Checks: ✓
- Email Recipients: your@email.com
- Check Mode: fast
- Frequency: weekly/daily/monthly
