<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Unauthorized</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="text-center">
        <div class="mb-6 text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <h1 class="text-6xl font-bold text-gray-800">403</h1>
        <p class="text-2xl font-semibold text-gray-600 mt-2">Access Denied</p>
        <p class="text-gray-500 mt-4 mb-8 max-w-md mx-auto">
            Sorry, you don't have permission to view this page. It looks like this area is restricted to authorized
            personnel only.
        </p>

        <div class="space-x-4">
            <a href="{{ url()->previous() }}"
                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                Go Back
            </a>

            <a href="/" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                Go Home
            </a>
        </div>
    </div>

</body>

</html>