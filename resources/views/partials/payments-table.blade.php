<div class="card card-bordered card-preview mt-4">
    <div class="card-inner">
        <table class="datatable-init-export nowrap table" data-export-title="Export">
            <thead>
                <tr>
                    <th>Payment Type</th>
                    <th>Invoice Number</th>
                    <th>Remita RR</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Payment Date</th>
                    <th>Letter Of Intent</th>
                    <th>Confirmation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ enum_payment_types()[$payment->payment_type] }}
                        </td>
                        <td>{{ $payment->invoice_number }}</td>
                        <td>{{ $payment->rrr }}</td>
                        <td>&#8358;{{ number_format($payment->amount, 2) }}</td>
                        <td><span
                                class="tb-status text-{{ $payment->payment_status != 1 ? 'warning' : 'success' }}">{{ $payment->payment_status != 1 ? 'PENDING' : 'PAID' }}</span>
                        </td>
                        <td>{{ $payment->paid_at }}</td>
                        <td>
                            @if (!empty($payment->letter_of_intent))
                                <a href="{{ 'storage/' . $payment->letter_of_intent }}" target="_blank">
                                    View PDF
                                </a>
                            @else
                                {{ 'NILL' }}
                            @endif
                        </td>
                        <td><span
                                class="tb-status text-warning">{{ $payment->approval_status == 0 ? 'Awaiting Approval' : '' }}</span>
                        </td>
                        <td>
                            
                            <a href="{{ route('payment.invoice', $payment->id) }}" target="_blank" title="Print"><span
                                    class="nk-menu-icon text-secondary"><em class="icon ni ni-printer"></em></span></a>
                            @if ($payment->payment_status == 1)
                                <a href="{{ route('payment.invoice.download', $payment->id) }}" target="_blank"
                                    title="Download Receipt"><span class="nk-menu-icon text-secondary"><em
                                            class="icon ni ni-download text-teal"></em></span></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div><!-- .card-preview -->
