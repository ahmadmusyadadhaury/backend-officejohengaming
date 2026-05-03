<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Meeting Room Booking System</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow p-8">
            <h1 class="text-2xl font-bold text-center mb-2">Meeting Room Booking System</h1>
            <p class="text-gray-500 text-center mb-6">Book rooms easily and avoid scheduling conflicts.</p>

            <div class="flex flex-col gap-3">
                @guest
                    <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded">
                            Register
                        </a>
                    @endif
                @else
                    <a href="{{ route('rooms.index') }}" class="flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded">
                        View Available Rooms
                    </a>
                    <a href="{{ route('bookings.index') }}" class="flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">
                        My Bookings
                    </a>
                @endguest
            </div>
        </div>
    </body>
</html>
