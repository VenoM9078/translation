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

            <div class="mb-4">
                <p class="text-gray-600">Current Date and MinusOneHour | Timezone:</p>
                <div class="mt-4 flex flex-wrap justify-center">
                    <span
                        class="inline-block bg-green-200 rounded-lg px-3 py-1 text-sm font-semibold text-green-400 m-1">{{ $currentDateTime }}
                        / {{ $currentDateTimeMinusOneHour }}</span>
                    <span
                        class="inline-block bg-green-200 rounded-lg px-3 py-1 text-sm font-semibold text-green-200 m-1">{{ $timezone }}
                    </span>

                </div>
            </div>

            <div class="mb-4">
                <p class="text-gray-600">Last Executed Query:</p>
                <div class="mt-4 flex flex-wrap justify-center">
                    <span
                        class="inline-block bg-green-200 rounded-lg px-3 py-1 text-sm font-semibold text-green-700 m-1">{{ $lastQuery['query'] }}
                        </span>
                        Values:
                    @foreach ($lastQuery['bindings'] as $binding)
                        <span
                            class="inline-block bg-green-200 rounded-lg px-3 py-1 text-sm font-semibold text-green-700 m-1">{{ $binding }}</span>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <p class="text-gray-600">Interpretations with Reminder Email Sent:</p>
                <div class="mt-4 flex flex-wrap justify-center">
                    @forelse ($interpretationsSent as $interpretation)
                        <span
                            class="inline-block bg-purple-200 rounded-full px-3 py-1 text-sm font-semibold text-purple-700 m-1">ID:
                            {{ $interpretation->id }}</span>
                        {{-- display interpretation session topic, start date and end date --}}
                        <span
                            class="inline-block bg-purple-200 rounded-sm px-6 py-3 text-sm font-semibold text-purple-700 m-1">Topic:
                            {{ $interpretation->session_topics }} <br>
                            Start Time: {{ $interpretation->start_time }} <br>
                            End Time: {{ $interpretation->end_time }} <br>
                        </span>
                    @empty
                        <span
                            class="inline-block bg-red-200 rounded-full px-3 py-1 text-sm font-semibold text-red-700 m-1">No
                            Interpretations with Sent Email</span>
                    @endforelse
                </div>
            </div>
            {{-- now display those interpretations --}}
            <div class="mb-4">
                <p class="text-gray-600">Interpretations with Reminder Email Enabled:</p>
                <div class="mt-4 flex flex-wrap justify-center">
                    @forelse ($interpretations as $interpretation)
                        <span
                            class="inline-block bg-yellow-200 rounded-full px-3 py-1 text-sm font-semibold text-yellow-700 m-1">ID:
                            {{ $interpretation->id }}</span>
                        {{-- display interpretation session topic, start date and end date --}}
                        <span
                            class="inline-block bg-yellow-200 rounded-sm px-6 py-3 text-sm font-semibold text-yellow-700 m-1">
                            Topic:
                            {{ $interpretation->session_topics }} <br>
                            Start Time: {{ $interpretation->start_time }} <br>
                            End Time: {{ $interpretation->end_time }} <br>
                        </span>
                     @endforeach
                </div>
        </div>
    </div>
</body>

</html>
