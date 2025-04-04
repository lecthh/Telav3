<!DOCTYPE html>
<html lang="en">

@include('head', ['title' => 'Account Blocked'])

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-cPrimary px-6 py-4">
            <div class="flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h1 class="ml-3 text-xl font-bold text-white">Account Blocked</h1>
            </div>
        </div>

        <!-- Content -->
        <div class="px-6 py-8">
            <div class="space-y-6">
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <div class="text-center">
                    <h2 class="text-xl font-semibold text-gray-800">Your Account Has Been Blocked</h2>
                    <p class="mt-2 text-gray-600">We've sent an email explaining the reason for this action.</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md">
                    <p class="text-sm text-gray-700">If you believe this is an error or would like to appeal this decision, please contact our support team using the button below.</p>
                </div>

                <div class="flex flex-col space-y-3">
                    <a href="mailto:telaprinthub@gmail.com" class="w-full bg-cPrimary hover:bg-cPrimary/90 text-white py-2 px-4 rounded-md text-center transition duration-300">
                        Contact Support
                    </a>
                    <a href="/" class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-center hover:bg-gray-50 transition duration-300">
                        Return to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>