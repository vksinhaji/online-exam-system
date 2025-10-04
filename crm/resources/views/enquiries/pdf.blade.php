<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enquiry #{{ $enquiry->id }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #111; font-size: 12px; }
        .container { width: 100%; padding: 16px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .title { font-size: 18px; font-weight: bold; }
        .muted { color: #555; }
        .section { border: 1px solid #ddd; border-radius: 6px; padding: 12px; margin-top: 10px; }
        .row { display: table; width: 100%; table-layout: fixed; }
        .col { display: table-cell; vertical-align: top; padding-right: 8px; }
        .col-1-2 { width: 50%; }
        ol { margin: 0; padding-left: 18px; }
        .small { font-size: 11px; }
    </style>
</head>
<body>
<div class="container">
  <div class="header">
    <div>
      <div class="title">Enquiry #{{ $enquiry->id }}</div>
      <div class="muted small">Created {{ optional($enquiry->created_at)->format('Y-m-d H:i') }}</div>
    </div>
  </div>

  <div class="section">
    <div class="row">
      <div class="col col-1-2">
        <div class="muted small">Customer Name</div>
        <div>{{ $enquiry->customer_name }}</div>
      </div>
      <div class="col col-1-2">
        <div class="muted small">Mobile Number</div>
        <div>{{ $enquiry->mobile_number }}</div>
      </div>
    </div>
    <div class="row" style="margin-top:6px">
      <div class="col col-1-2">
        <div class="muted small">Service</div>
        <div>{{ $enquiry->service->name ?? '-' }}</div>
      </div>
      <div class="col col-1-2">
        <div class="muted small">Expected Time (days)</div>
        <div>{{ $enquiry->service->expected_completion_days ?? '-' }}</div>
      </div>
    </div>
    <div class="row" style="margin-top:6px">
      <div class="col col-1-2">
        <div class="muted small">Estimated Completion</div>
        <div>{{ optional($enquiry->estimated_completion_date)->format('Y-m-d') ?? '-' }}</div>
      </div>
    </div>
  </div>

  <div class="section">
    <div style="font-weight:bold; margin-bottom:6px">Documents Required</div>
    <ol>
      @forelse(($enquiry->service->documentRequirements ?? []) as $doc)
        <li>
          {{ $doc->name }}
          @if($doc->is_mandatory)
            <span class="muted small">(Mandatory)</span>
          @endif
        </li>
      @empty
        <li class="muted">No documents configured for this service.</li>
      @endforelse
    </ol>
  </div>

  @if($enquiry->notes)
  <div class="section">
    <div style="font-weight:bold; margin-bottom:6px">Notes</div>
    <div>{{ $enquiry->notes }}</div>
  </div>
  @endif
</div>
</body>
</html>
