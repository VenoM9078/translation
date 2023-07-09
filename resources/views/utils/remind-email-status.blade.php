<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Reminder Status</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-blue-50">

    <div class="h-screen flex items-center justify-center">
        <div class="container bg-white shadow-md rounded px-8 pt-6 mb-4 max-w-md">
            <div class="mb-4">
                <h2 class="text-2xl font-bold mb-2 text-gray-800">FlowTranslate - Email Reminder Status</h2>
                <p class="text-gray-600">Sent Email to Interpretation IDs:</p>
                <div class="mt-4 flex flex-wrap justify-center">
                    @forelse ($interpretationIds as $id)
                        <span
                            class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 m-1">{{ $id }}</span>
                    @empty
                        <span
                            class="inline-block bg-red-200 rounded-full px-3 py-1 text-sm font-semibold text-red-700 m-1">No
                            Email Sent</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>

</html>
