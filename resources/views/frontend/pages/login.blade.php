<!DOCTYPE html>
<html lang="en" class="border-l">
<head>
    <meta charset="UTF-8">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Login</title>
    <style>
        * {
            margin:0;
            padding:0;
        }
        .input {
            transition: border 0.2s ease-in-out;
            min-width: 280px
        }
        .input:focus+.label,
        .input:active+.label,
        .input.filled+.label {
            font-size: .75rem;
            transition: all 0.2s ease-out;
            top: -0.3rem;
            color: #6b7280;
        }
        .label {
            transition: all 0.2s ease-out;
            top: 0.4rem;
            left: 0;
        }
    </style>
</head>
<body>
<header>
    <a aria-label="Linkedin" class="z-10 mt-9 absolute md:ml-12 ml-9" href="/">
        <img src="https://importir.com/images/com-01.png" onclick="window.location.open(window.location.origin)" class="w-36" alt="">
    </a>
</header>
<div class="h-screen bg-white relative flex flex-col space-y-10 justify-center items-center">
    <div class="bg-white md:shadow-lg shadow-none rounded p-6 w-96" >
        <h1 class="text-3xl font-bold leading-normal" >Sign in</h1>
        <form class="space-y-10 mt-5">
            <div class="mb-4 relative">
                <input id="email" class="w-full rounded px-3 border border-gray-500 pt-5 pb-2 focus:outline-none input active:outline-none" type="text" autofocus>
                <label for="email" class="label absolute mb-0 -mt-2 pt-4 pl-3 leading-tighter text-gray-500 text-base mt-2 cursor-text">Email or Phone</label>
            </div>
            <div class="relative flex items-center border border-gray-500 focus:ring focus:border-blue-500 rounded">
                <input id="password" class="w-full rounded px-3 pt-5 outline-none pb-2 focus:outline-none active:outline-none input active:border-blue-500" type="password"/>
                <label id="pwdText" for="password" class="label absolute mb-0 -mt-2 pt-4 pl-3 leading-tighter text-gray-500 text-base mt-2">Password</label>
                <a id="labelShow" class="text-sm font-bold text-blue-700 hover:bg-gray-200 rounded-full px-2 py-1 mr-1 leading-normal cursor-pointer" onclick="changeType()">show</a>
            </div>
            <div class="-m-2">
                <a class="font-bold text-blue-700 hover:bg-gray-200 hover:underline hover:p-5 p-4 rounded-full" href="#">Forgot password?</a>
            </div>
            <button class="w-full text-center bg-yellow-400 hover:bg-blue-900 rounded-full text-white py-3 font-medium">Sign in</button>
        </form>
    </div>
    <p>New To This Platform?<a class="text-blue-700 font-bold hover:bg-gray-200 hover:underline hover:p-5 p-2 rounded-full" href="{{ url("register") }}">Join now</a></p>
</div>
<script>
    function changeType() {
        const pass = document.querySelector("#password")
        if(pass.type == "password") {
            pass.type = "text"
            document.querySelector("#pwdText").style.display = "none"
            document.querySelector("#labelShow").textContent = "hide"
        } else {
            pass.type = "password"
            document.querySelector("#pwdText").style.display = ""
            document.querySelector("#labelShow").textContent = "show"
        }
    }
</script>
</body>
</html>