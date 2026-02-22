<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">

<style>

body {
    font-family: dejavusans;
    direction: rtl;
    text-align: right;
    line-height: 2;
    position: relative;
}

/* علامة مائية */
.watermark {
    position: fixed;
    top: 35%;
    left: 20%;
    font-size: 90px;
    color: rgba(200,200,200,0.15);
    transform: rotate(-30deg);
}

/* الترويسة */
.header {
    text-align: center;
    margin-bottom: 20px;
}

.logo {
    width: 120px;
}

.contract-number {
    text-align: left;
    font-size: 14px;
    margin-top: -20px;
}

/* بيانات */
.info-box {
    border: 1px solid #000;
    padding: 15px;
    margin-top: 20px;
}

/* التوقيع */
.signatures {
    margin-top: 60px;
}

/* الختم */
.stamp {
    position: absolute;
    bottom: 120px;
    left: 40px;
    border: 3px solid #c0392b;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    text-align: center;
    padding-top: 35px;
    font-weight: bold;
    color: #c0392b;
}

/* QR */
.qr {
    position: absolute;
    bottom: 60px;
    right: 40px;
}

/* التذييل */
.footer {
    position: fixed;
    bottom: 10px;
    width: 100%;
    text-align: center;
    font-size: 12px;
}

</style>
</head>

<body>

<div class="watermark">
قصر الماسة
</div>

<div class="header">
    <img src="{{ public_path('logo.png') }}" class="logo">
    <h2>قصر الماسة للأفراح</h2>
</div>

<div class="contract-number">
    رقم العقد: {{ $contractNumber }}
</div>

<hr>

<div class="info-box">
    <strong>اسم العميل:</strong> {{ $booking->client->name }}<br>
    <strong>رقم الجوال:</strong> {{ $booking->client->phone }}<br>
    <strong>اسم القاعة:</strong> {{ $booking->hall->name }}<br>
    <strong>تاريخ المناسبة:</strong> {{ $booking->event_date }}<br>
    <strong>إجمالي العقد:</strong> {{ number_format($booking->total_price) }} ريال<br>
    <strong>المدفوع:</strong> {{ number_format($booking->paid_amount) }} ريال<br>
    <strong>المتبقي:</strong> {{ number_format($booking->remaining_amount) }} ريال
</div>

<div class="signatures">
    <p>توقيع الإدارة: ________________________</p>
    <p>توقيع العميل: ________________________</p>
</div>

<div class="stamp">
ختم رسمي<br>
قصر الماسة
</div>

<div class="qr">
    {!! $qrSvg !!}
</div>

<div class="footer">
هذا العقد صادر إلكترونيًا من نظام قصر الماسة — جميع الحقوق محفوظة
</div>

</body>
</html>