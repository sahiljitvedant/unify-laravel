<h1>Hi {{ $payment->user->name ?? 'Member' }},</h1>
<p>Thank you for your payment. Please find your invoice attached.</p>
<p>Total Paid: ₹{{ $payment->total_amount_paid }}</p>
<p>Remaining Amount: ₹{{ $payment->total_amount_remaining }}</p>
