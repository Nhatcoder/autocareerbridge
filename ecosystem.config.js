module.exports = {
    apps: [
        {
            name: "laravel-server",
            script: "artisan",
            args: "serve --host=0.0.0.0 --port=8000",
            interpreter: "php",
            watch: true,
        },
        {
            name: "laravel-queue",
            script: "artisan",
            args: "queue:work --tries=3 --sleep=3",
            interpreter: "php",
            watch: false,
        },
        {
            name: "vite-dev",
            script: "npm",
            args: "run dev -- --host 192.168.0.152 --port 5173",
            watch: false,
        }
    ],
};
