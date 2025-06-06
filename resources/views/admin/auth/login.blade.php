<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>
<section class="w-full h-screen grid place-content-center">
    <form action="/admin/login" method="post" class="grid gap-5 w-sm">
        @csrf
        <h2 class="text-sm text-zinc-500">LabToolz</h2>
        <h1 class="text-2xl text-black font-bold dark:text-white">Admin Login Page</h1>
        <div class="grid gap-5">
            <flux:input type="email" label="Email" name="email" />
            <flux:input type="password" label="Password" name="password" />
        </div>
        <div class="flex gap-5 justify-end">
            <flux:button as="a" href="/" icon="arrow-uturn-left">Back</flux:button>
            <flux:button type="submit" icon:trailing="arrow-right" variant="primary">Submit</flux:button>
        </div>
    </form>
</section>
</body>

</html>
