# SMS Code Troubleshooting Guide

## 🔍 **Current Status Analysis**

### ✅ **What's Working:**
- **API Key**: Valid and authenticated
- **Balance**: $864.66 available
- **Services**: All services available (WhatsApp, Telegram, etc.)
- **Number Provisioning**: Successfully getting phone numbers
- **Status Checking**: API responding correctly

### ❌ **Potential Issues:**

## **1. Database Connection Issues**
```
SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'
```
**Solution:**
- Check your `.env` file database credentials
- Ensure MySQL is running
- Verify database user permissions

## **2. SMS Delivery Timing**
**Status**: `STATUS_WAIT_CODE` - SMS is being waited for
**Common Causes:**
- **Network delays** (5-15 minutes normal)
- **Service provider issues**
- **Phone number temporary unavailability**
- **High demand periods**

## **3. Service-Specific Issues**

### **WhatsApp (wa) Service:**
- **Requires**: Active WhatsApp account
- **Timing**: 10-30 minutes for code delivery
- **Issues**: 
  - WhatsApp blocking temporary numbers
  - Rate limiting
  - Geographic restrictions

### **Telegram (tg) Service:**
- **Requires**: Active Telegram account
- **Timing**: 5-15 minutes for code delivery
- **Issues**:
  - Telegram security measures
  - Account verification requirements

## **4. API Response Status Codes**

| Status | Meaning | Action |
|--------|---------|--------|
| `STATUS_WAIT_CODE` | Waiting for SMS | **Wait 5-15 minutes** |
| `STATUS_OK` | SMS received | **Code available** |
| `STATUS_CANCEL` | Order cancelled | **Create new order** |
| `NO_ACTIVATION` | Order not found | **Check order ID** |

## **5. Troubleshooting Steps**

### **Step 1: Check Recent Orders**
```bash
# Check database for recent orders
php artisan tinker --execute="use App\Models\Verification; dd(Verification::where('status', 1)->orderBy('created_at', 'desc')->get()->toArray());"
```

### **Step 2: Test SMS API Directly**
```bash
# Get a new number
curl "https://daisysms.com/stubs/handler_api.php?api_key=YOUR_API_KEY&action=getNumber&service=wa&max_price=1.00"

# Check status
curl "https://daisysms.com/stubs/handler_api.php?api_key=YOUR_API_KEY&action=getStatus&id=ORDER_ID"
```

### **Step 3: Check Application Logs**
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Look for SMS-related errors
grep -i "sms\|verification\|order" storage/logs/laravel.log
```

### **Step 4: Verify Environment Variables**
```bash
# Check API keys
php artisan tinker --execute="echo 'KEY: ' . env('KEY') . PHP_EOL; echo 'WKEY: ' . env('WKEY') . PHP_EOL;"
```

## **6. Common Solutions**

### **Solution 1: Wait Longer**
- **WhatsApp**: 10-30 minutes
- **Telegram**: 5-15 minutes
- **Other services**: 5-20 minutes

### **Solution 2: Try Different Services**
- **WhatsApp** → **Telegram**
- **Telegram** → **WhatsApp**
- **Try other services** (Google, Facebook, etc.)

### **Solution 3: Check Service Availability**
```bash
# Check service stock
curl "https://daisysms.com/stubs/handler_api.php?api_key=YOUR_API_KEY&action=getPrices&service=wa"
```

### **Solution 4: Cancel and Retry**
```bash
# Cancel stuck order
curl "https://daisysms.com/stubs/handler_api.php?api_key=YOUR_API_KEY&action=setStatus&id=ORDER_ID&status=8"

# Create new order
curl "https://daisysms.com/stubs/handler_api.php?api_key=YOUR_API_KEY&action=getNumber&service=wa&max_price=1.00"
```

## **7. Application-Specific Issues**

### **Issue: Database Connection**
**Error**: `Access denied for user 'root'@'localhost'`
**Fix**:
1. Check `.env` file database settings
2. Ensure MySQL is running
3. Verify database credentials

### **Issue: Missing SMS Codes in UI**
**Possible Causes**:
1. **JavaScript errors** preventing code display
2. **AJAX polling** not working
3. **Database updates** not reflecting in UI

**Debug Steps**:
1. Check browser console for errors
2. Verify AJAX requests are working
3. Check if `check_sms()` function is being called

## **8. Testing Commands**

### **Test API Balance:**
```bash
curl "https://daisysms.com/stubs/handler_api.php?api_key=S8CWpKgrUurrBp1yvG7Qbg6JY8MsSI&action=getBalance"
```

### **Test Service Availability:**
```bash
curl "https://daisysms.com/stubs/handler_api.php?api_key=S8CWpKgrUurrBp1yvG7Qbg6JY8MsSI&action=getPrices&service=wa"
```

### **Test Number Provisioning:**
```bash
curl "https://daisysms.com/stubs/handler_api.php?api_key=S8CWpKgrUurrBp1yvG7Qbg6JY8MsSI&action=getNumber&service=wa&max_price=1.00"
```

### **Test SMS Status:**
```bash
curl "https://daisysms.com/stubs/handler_api.php?api_key=S8CWpKgrUurrBp1yvG7Qbg6JY8MsSI&action=getStatus&id=ORDER_ID"
```

## **9. Recommended Actions**

### **Immediate Actions:**
1. ✅ **Check database connection** (fix MySQL credentials)
2. ✅ **Wait 15-30 minutes** for SMS delivery
3. ✅ **Try different services** (Telegram instead of WhatsApp)
4. ✅ **Check application logs** for errors

### **If Still Not Working:**
1. **Cancel stuck orders** and create new ones
2. **Check service availability** for different providers
3. **Verify JavaScript** is working in browser
4. **Test with different phone numbers**

## **10. Contact Support**

If issues persist:
- **DaisySMS Support**: Check their status page
- **Service Provider**: Contact specific service (WhatsApp, Telegram)
- **Application Logs**: Check for specific error messages

---

**Last Updated**: $(date)
**API Status**: ✅ Working
**Balance**: $864.66
**Services**: ✅ Available 