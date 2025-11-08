# DigitalOcean Droplet Setup Guide
## Exact Configuration for FieldOps-Pro

Follow these exact steps when creating your droplet:

---

## Step 1: Create Droplet

Go to: https://cloud.digitalocean.com/droplets/new

---

## Step 2: Choose an Image

### ✅ SELECT THIS:
```
Distributions → Ubuntu → 24.04 (LTS) x64
```

### ❌ DON'T SELECT:
- ~~Laravel marketplace image~~ (outdated, pre-configured)
- ~~Ubuntu 22.04~~ (works but 24.04 is newer)
- ~~Docker marketplace image~~ (we're done with Docker!)

**Why Ubuntu 24.04?**
- Latest LTS (Long Term Support)
- Security updates until 2029
- Clean slate for our custom setup

---

## Step 3: Choose a Plan

### For Testing/Small Traffic:
```
Droplet Type: Basic
CPU Options: Regular
Size: $12/month
  - 2 GB RAM / 1 CPU
  - 50 GB SSD
  - 2 TB transfer
```

### For Production/Medium Traffic:
```
Droplet Type: Basic
CPU Options: Regular
Size: $18/month
  - 2 GB RAM / 2 CPUs
  - 60 GB SSD
  - 3 TB transfer
```

### For High Traffic:
```
Droplet Type: Basic
CPU Options: Regular
Size: $24/month
  - 4 GB RAM / 2 CPUs
  - 80 GB SSD
  - 4 TB transfer
```

**Recommendation:** Start with **$12/month** (2GB RAM). You can always resize later!

**Why not cheaper $6/month?**
- 1GB RAM is tight for Laravel + PostgreSQL + Redis
- Composer install will struggle
- May need to create swap space

---

## Step 4: Choose a Datacenter Region

Select the region **closest to your users**:

### US Options:
```
✅ New York (NYC1, NYC2, NYC3)      - East Coast
✅ San Francisco (SFO2, SFO3)        - West Coast
```

### Europe:
```
✅ Frankfurt (FRA1)                  - Germany
✅ Amsterdam (AMS3)                  - Netherlands
✅ London (LON1)                     - UK
```

### Asia:
```
✅ Singapore (SGP1)                  - Southeast Asia
✅ Bangalore (BLR1)                  - India
```

**Recommendation:** If mostly US users → **New York**

---

## Step 5: VPC Network

```
Default VPC network for NYC1 (or your region)
```

Leave as default - it's fine!

---

## Step 6: Authentication

### Option A: SSH Key (Recommended)

If you have an SSH key:
```
☑️ Select your existing SSH key
```

If you don't have one, create it now:

**On Mac/Linux:**
```bash
ssh-keygen -t rsa -b 4096 -C "your-email@example.com"
# Press Enter to accept default location
# Enter a passphrase (optional but recommended)

# Copy your public key
cat ~/.ssh/id_rsa.pub
```

**On Windows (PowerShell):**
```powershell
ssh-keygen -t rsa -b 4096 -C "your-email@example.com"
# Copy your public key
type $env:USERPROFILE\.ssh\id_rsa.pub
```

Then in DigitalOcean:
1. Click "New SSH Key"
2. Paste your public key
3. Name it (e.g., "My Laptop")
4. Click "Add SSH Key"

### Option B: Password (Not Recommended)
```
☑️ Password
```
You'll receive root password via email.

---

## Step 7: Choose Additional Options

### ✅ ENABLE THESE:
```
☑️ Monitoring (FREE)
   - CPU, bandwidth, disk metrics
   - Very useful for debugging

☐ IPv6 (optional)
   - Not needed unless you specifically want it

☐ User data (skip)
   - Our provision script handles everything

☐ Droplet Agent (optional)
   - Useful for advanced metrics
```

### ❌ DON'T ENABLE:
```
☐ Managed databases
   - We install PostgreSQL on the droplet (included in $12/month)
   - Managed DB is $15+ extra per month
```

---

## Step 8: Finalize Details

```
How many Droplets?
  1 Droplet

Choose a hostname:
  fieldops-pro
  (or whatever you prefer - this is just for identification)

Add tags (optional):
  production, laravel, fieldops
  (helps organize your droplets)

Select Project:
  Choose your project or leave as default
```

---

## Step 9: Create Droplet

```
Click: Create Droplet
```

⏱️ **Wait 55-60 seconds** for droplet to be created

---

## Step 10: Note Your IP Address

Once created, you'll see:
```
fieldops-pro
New York 3
68.183.xxx.xxx  ← THIS IS YOUR DROPLET IP
```

**Copy this IP address** - you'll need it!

---

## Summary of What You Selected:

```
✅ Image: Ubuntu 24.04 (LTS) x64
✅ Plan: Basic - Regular - $12/month (2GB RAM)
✅ Region: New York 3 (or your choice)
✅ Authentication: SSH Key
✅ Additional: Monitoring enabled
✅ Hostname: fieldops-pro
```

**Total Cost: $12/month** (includes everything except domain)

---

## What's Next?

After your droplet is created:

1. **Test SSH access:**
   ```bash
   ssh root@YOUR_DROPLET_IP
   ```

2. **Run the provision script:**
   ```bash
   curl -o provision.sh https://raw.githubusercontent.com/nmtechnology/FieldOps-Pro/main/deploy/provision.sh
   chmod +x provision.sh
   ./provision.sh
   ```

3. **Follow DROPLET-DEPLOYMENT.md** for the rest!

---

## Quick Reference Card

Save this for later:

```
Droplet IP: _________________
Root Password/SSH Key: (you have this)
Database Name: fieldops_pro
Database User: fieldops_user
Database Password: (set during provision - CHANGE IT!)
Deployer User: deployer
App Directory: /var/www/fieldops-pro
```

---

## FAQs

**Q: Can I use the $6/month droplet?**
A: Technically yes, but you'll need to add swap space and it might be slow. $12 is recommended.

**Q: Should I add a managed database?**
A: No, PostgreSQL is installed on the droplet (included). Managed DB is $15+ extra.

**Q: Can I resize later?**
A: Yes! DigitalOcean allows resizing (though downgrading RAM requires a snapshot).

**Q: What about backups?**
A: Enable backups in droplet settings ($2.40/month extra, 20% of droplet cost). Or use DigitalOcean's Snapshots manually (free, but manual).

**Q: IPv6 needed?**
A: Not required. IPv4 is sufficient for 99% of use cases.

---

Ready to create your droplet? Follow the steps above! 🚀
