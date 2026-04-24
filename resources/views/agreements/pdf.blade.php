<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rental Agreement</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #111;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 14px;
        }

        .label {
            font-weight: bold;
        }

        .signature-block {
            margin-top: 60px;
        }

        .signature {
            width: 45%;
            display: inline-block;
            text-align: center;
            margin-right: 5%;
        }

        .line {
            border-top: 1px solid #000;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <h1>Rental Agreement</h1>

    <div class="section">
        This rental agreement is made between
        <strong>{{ $agreement->owner->name ?? 'Owner' }}</strong>
        and
        <strong>{{ $agreement->tenant->name ?? 'Tenant' }}</strong>.
    </div>

    <div class="section">
        <span class="label">Property:</span>
        {{ $agreement->property->title ?? 'Property' }}
    </div>

    <div class="section">
        <span class="label">Location:</span>
        {{ $agreement->property->location ?? '' }}
    </div>

    <div class="section">
        <span class="label">Start Date:</span>
        {{ $agreement->start_date }}
    </div>

    <div class="section">
        <span class="label">End Date:</span>
        {{ $agreement->end_date }}
    </div>

    <div class="section">
        <span class="label">Monthly Rent:</span>
        {{ number_format($agreement->rent_amount) }} Tk
    </div>

    <div class="section">
        The tenant agrees to pay rent on time and follow the property rules.
        The owner agrees to provide the property for residential use during the agreement period.
    </div>

    <div class="signature-block">
        <div class="signature">
            <div class="line"></div>
            Owner Signature
        </div>

        <div class="signature">
            <div class="line"></div>
            Tenant Signature
        </div>
    </div>
</body>
</html>