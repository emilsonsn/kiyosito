@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <section class="pt-100 pb-100 custom--bg-two">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="section-header text-center mb-5">
                        <h2 class="section-title">About Kiyosito</h2>
                    </div>

                    <div class="card glass--bg p-4 p-md-5">
                        <p>
                            Kiyosito is a protocol-driven research and governance initiative focused on the design,
                            coordination, and long-term stewardship of decentralized capital systems. Rather than
                            operating as a traditional investment product, Kiyosito explores how collective
                            decision-making and transparent protocol rules can be applied to capital allocation.
                        </p>

                        <h4 class="mt-4">What Kiyosito Is</h4>
                        <p class="mb-2">A framework designed to:</p>
                        <ul class="list list-style-two mb-3">
                            <li>Study and implement decentralized governance mechanisms.</li>
                            <li>Define structured processes for proposal signaling and coordination.</li>
                            <li>Establish transparent rules for treasury policy and protocol evolution.</li>
                        </ul>
                        <p class="mb-0">
                            <strong>Note:</strong> Kiyosito does not provide financial advice, asset management, or
                            guaranteed outcomes.
                        </p>

                        <h4 class="mt-4">The Role of the ITO Token</h4>
                        <p class="mb-0">
                            Functions strictly as a utility and governance layer. It enables eligible participants to
                            engage in signaling processes and decision mechanisms. The ITO token does not represent
                            equity, ownership, profit rights, or entitlement to financial returns.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

