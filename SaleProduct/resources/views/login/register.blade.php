<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Hiệu ứng cho form đăng ký */
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
<body class="bg-gradient-to-r from-green-400 via-blue-500 to-purple-500 min-h-screen flex items-center justify-center">

    <!-- Form đăng ký -->
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg fade-in">
        <h2 class="text-3xl font-bold text-center mb-8">Đăng Ký</h2>
        
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <!-- Họ và Tên -->
            <div class="mb-6 input-animation">
                <input type="text" id="name" name="name" class="border p-2 w-full focus:outline-none focus:border-blue-500" placeholder=" " required minlength="3" maxlength="255"/>
                <label for="name">Họ và Tên</label>
            </div>

            <!-- Email -->
            <div class="mb-6 input-animation">
                <input type="email" id="email" name="email" class="border p-2 w-full focus:outline-none focus:border-blue-500" placeholder=" " required />
                <label for="email">Email</label>
            </div>

            <!-- Địa chỉ -->
            <div class="mb-6 input-animation">
                <input type="text" id="address" name="address" class="border p-2 w-full focus:outline-none focus:border-blue-500" placeholder=" " required />
                <label for="address">Địa chỉ</label>
            </div>

            <!-- Số điện thoại -->
            <div class="mb-6 input-animation">
                <input type="tel" id="phone" name="phone" class="border p-2 w-full focus:outline-none focus:border-blue-500" placeholder=" " pattern="[0-9]{10,15}" required />
                <label for="phone">Số Điện Thoại</label>
            </div>

            <!-- Mật khẩu -->
            <div class="mb-6 input-animation">
                <input type="password" id="password" name="password" class="border p-2 w-full focus:outline-none focus:border-blue-500" placeholder=" " required minlength="6"/>
                <label for="password">Mật Khẩu</label>
            </div>

            <!-- Xác nhận mật khẩu -->
            <div class="mb-6 input-animation">
                <input type="password" id="confirm_password" name="password_confirmation" class="border p-2 w-full focus:outline-none focus:border-blue-500" placeholder=" " required minlength="6"/>
                <label for="confirm_password">Xác Nhận Mật Khẩu</label>
            </div>
            <!-- Nút đăng ký -->
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-300">
                Đăng Ký
            </button>
        </form>

        <!-- Đăng nhập -->
        <div class="text-center mt-6">
            <p>Đã có tài khoản? <a href="/login" class="text-blue-600 hover:underline">Đăng Nhập</a></p>
        </div>
    </div>
    @if ($errors->has('password'))
        <div class="text-red-600">
            {{ $errors->first('password') }}
        </div>
    @endif

    <script>
        // Kiểm tra xác nhận mật khẩu
        const form = document.querySelector('form');
        const password = document.getElementById('password');
        const confirm_password = document.getElementById('confirm_password');

        form.addEventListener('submit', function(event) {
            if (password.value !== confirm_password.value) {
                event.preventDefault();
                alert('Mật khẩu và xác nhận mật khẩu không khớp.');
            }
        });
    </script>
</body>
</html>
