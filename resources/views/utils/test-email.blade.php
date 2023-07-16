<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Reminder Status</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-blue-50 flex items-center justify-center min-h-screen">

     <div class="bg-white rounded shadow-lg p-6 md:p-8 w-full md:w-96">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">FlowTranslate - Test Email | Your IP: {{$ip ?? '-'}} | Time: {{$date ?? '-'}} ({{$isLocal ?? 1}})</h2>
        <p class="text-gray-600 mb-4">Enter User Email:</p>
        <form class="form-group" action="{{ route('send-email') }}" method="post">
            @csrf
            <input type="email" class="form-control w-full mb-4 p-3 rounded border border-gray-200" name="user" id="">
            <input type="submit" class="btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full" value="Send">
        </form>
        @if (session('message'))
            <div class="alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4" role="alert">
                <strong class="font-bold">Message!</strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
    </div>
</body>

</html>
