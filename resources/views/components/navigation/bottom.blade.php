<!-- ===== FOOTER (STICKY BOTTOM) ===== -->
<footer class="bg-primary text-white">
    <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-8 text-sm">
        <div>
            <h4 class="font-semibold mb-3">{{ config('app.name') }}</h4>
            <p class="text-white/80 mb-4">
                Slogan goes here...
            </p>
            <div class="flex gap-3">
                <span class="hover:text-gray-300 cursor-pointer"><i class="fa-brands fa-instagram"></i></span>
                <span class="hover:text-gray-300 cursor-pointer"><i class="fa-brands fa-whatsapp"></i></span>
                <span class="hover:text-gray-300 cursor-pointer"><i class="fa-brands fa-tiktok"></i></span>
            </div>
        </div>

        <div>
            <h4 class="font-semibold mb-3">Company Info</h4>
            <ul class="space-y-2 text-white/80">
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('carrier') }}">Carrier</a></li>
                <li>We are hiring</li>
                <li> <a href="{{ route('blog') }}">Blog</a> </li>
            </ul>
        </div>

        <div>
            <h4 class="font-semibold mb-3">Features</h4>
            <ul class="space-y-2 text-white/80">
                <li>Business Marketing</li>
                <li>User Analytic</li>
                <li>Live Chat</li>
                <li>Unlimited Support</li>
            </ul>
        </div>
    </div>

    <div class="text-center text-xs py-4 border-t border-white/20">
        Made With Love By Figmaland All Right Reserved
    </div>
</footer>
