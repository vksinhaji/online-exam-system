<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquiry #{{ $enquiry->id }}</title>
    <style>
        body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; color: #111827; }
        .container { max-width: 800px; margin: 0 auto; padding: 24px; }
        .header { display:flex; justify-content: space-between; align-items:center; }
        .title { font-size: 20px; font-weight: 600; }
        .meta { color: #6B7280; font-size: 12px; }
        .card { border: 1px solid #E5E7EB; border-radius: 8px; padding: 16px; margin-top: 16px; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .muted { color: #6B7280; }
        .print-btn { display: inline-block; padding: 8px 12px; background: #065f46; color: #fff; border-radius: 6px; text-decoration: none; }
        @media print { .no-print { display:none; } }
    </style>
</head>
<body>
<div class="container">
  <div class="header">
    <div>
      <div class="title">Enquiry #{{ $enquiry->id }}</div>
      <div class="meta">Created {{ optional($enquiry->created_at)->format('Y-m-d H:i') }}</div>
    </div>
    <div class="no-print">
      <a href="#" onclick="window.print()" class="print-btn">Print</a>
    </div>
  </div>

  <div class="card">
    <div class="row">
      <div>
        <div class="muted">Customer Name</div>
        <div>{{ $enquiry->customer_name }}</div>
      </div>
      <div>
        <div class="muted">Mobile Number</div>
        <div>{{ $enquiry->mobile_number }}</div>
      </div>
      <div>
        <div class="muted">Service</div>
        <div>{{ $enquiry->service->name ?? '-' }}</div>
      </div>
      <div>
        <div class="muted">Expected Time (days)</div>
        <div>{{ $enquiry->service->expected_completion_days ?? '-' }}</div>
      </div>
      <div>
        <div class="muted">Estimated Completion</div>
        <div>{{ optional($enquiry->estimated_completion_date)->format('Y-m-d') ?? '-' }}</div>
      </div>
    </div>
  </div>

  <div class="card">
    <div style="font-weight:600; margin-bottom:8px">Documents Required</div>
    <ol style="padding-left: 20px;">
      @forelse(($enquiry->service->documentRequirements ?? []) as $doc)
        <li>
          {{ $doc->name }}
          @if($doc->is_mandatory)
            <span class="muted">(Mandatory)</span>
          @endif
        </li>
      @empty
        <li class="muted">No documents configured for this service.</li>
      @endforelse
    </ol>
  </div>

  @if($enquiry->notes)
  <div class="card">
    <div style="font-weight:600; margin-bottom:8px">Notes</div>
    <div>{{ $enquiry->notes }}</div>
  </div>
  @endif
</div>
</body>
</html>
