<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Hiệu ứng cho form login */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Các hiệu ứng khác */
        .input-animation {
            position: relative;
        }

        .input-animation input {
            padding: 10px;
            width: 100%;
            font-size: 1rem;
            border: 2px solid #ccc;
            border-radius: 0.25rem;
            outline: none;
            background: none;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .input-animation label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            font-size: 1rem;
            color: #999;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .input-animation input:focus + label,
        .input-animation input:not(:placeholder-shown) + label {
            top: 0;
            font-size: 0.75rem;
            color: #007bff;
        }

        .input-animation input:focus {
            border-color: #007bff;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center fade-in">
    <!-- Form đăng nhập -->
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg fade-in">
        <h2 class="text-3xl font-bold text-center mb-8">Đăng Nhập</h2>

        <!-- Form đăng nhập -->
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <!-- Email -->
            <div class="mb-6 input-animation">
                <input type="email" id="email" name="email" class="border p-2 w-full focus:outline-none focus:border-blue-500" placeholder=" " required />
                <label for="email">Email</label>
            </div>

            <!-- Password -->
            <div class="mb-6 input-animation">
                <input type="password" id="password" name="password" class="border p-2 w-full focus:outline-none focus:border-blue-500" placeholder=" " required />
                <label for="password">Mật Khẩu</label>
            </div>

            <!-- Nút đăng nhập -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                Đăng Nhập
            </button>
        </form>

        <!-- Đăng ký và quên mật khẩu -->
        <div class="text-center mt-6">
            <a href="#" class="text-indigo-600 hover:underline">Quên mật khẩu?</a>
            <p class="mt-2">Chưa có tài khoản? <a href="/register" class="text-indigo-600 hover:underline">Đăng ký</a></p>
        </div>
    </div>

</body>
</html>
