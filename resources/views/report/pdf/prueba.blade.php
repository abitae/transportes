<html lang="en">
<head>
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="max-w-xl px-2 py-8 mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <div class="text-lg font-semibold text-gray-700">Your Company Name</div>
        </div>
        <div class="text-gray-700">
            <div class="mb-2 text-xl font-bold uppercase">Invoice</div>
            <div class="text-sm">Date: 01/05/2023</div>
            <div class="text-sm">Invoice #: {{ $invoiceNumber }}</div>
        </div>
    </div>
    <div class="pb-8 mb-8 border-b-2 border-gray-300">
        <h2 class="mb-4 text-2xl font-bold">Bill To:</h2>
        <div class="mb-2 text-gray-700">{{ $customerName }}</div>
        <div class="mb-2 text-gray-700">123 Main St.</div>
        <div class="mb-2 text-gray-700">Anytown, USA 12345</div>
        <div class="text-gray-700">johndoe@example.com</div>
    </div>
    <table class="w-full mb-8 text-left">
        <thead>
        <tr>
            <th class="py-2 font-bold text-gray-700 uppercase">Description</th>
            <th class="py-2 font-bold text-gray-700 uppercase">Quantity</th>
            <th class="py-2 font-bold text-gray-700 uppercase">Price</th>
            <th class="py-2 font-bold text-gray-700 uppercase">Total</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="py-4 text-gray-700">Product 1</td>
            <td class="py-4 text-gray-700">1</td>
            <td class="py-4 text-gray-700">$100.00</td>
            <td class="py-4 text-gray-700">$100.00</td>
        </tr>
        <tr>
            <td class="py-4 text-gray-700">Product 2</td>
            <td class="py-4 text-gray-700">2</td>
            <td class="py-4 text-gray-700">$50.00</td>
            <td class="py-4 text-gray-700">$100.00</td>
        </tr>
        <tr>
            <td class="py-4 text-gray-700">Product 3</td>
            <td class="py-4 text-gray-700">3</td>
            <td class="py-4 text-gray-700">$75.00</td>
            <td class="py-4 text-gray-700">$225.00</td>
        </tr>
        </tbody>
    </table>
    <div class="flex justify-end mb-8">
        <div class="mr-2 text-gray-700">Subtotal:</div>
        <div class="text-gray-700">$425.00</div>
    </div>
    <div class="mb-8 text-right">
        <div class="mr-2 text-gray-700">Tax:</div>
        <div class="text-gray-700">$25.50</div>

    </div>
    <div class="flex justify-end mb-8">
        <div class="mr-2 text-gray-700">Total:</div>
        <div class="text-xl font-bold text-gray-700">$450.50</div>
    </div>
    <div class="pt-8 mb-8 border-t-2 border-gray-300">
        <div class="mb-2 text-gray-700">Payment is due within 30 days. Late payments are subject to fees.</div>
        <div class="mb-2 text-gray-700">Please make checks payable to Your Company Name and mail to:</div>
        <div class="text-gray-700">123 Main St., Anytown, USA 12345</div>
    </div>
</div>

</body>
</html>