<footer class="bg-primary-900 text-white">
    <!-- Main Footer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-gold-400 to-gold-600 rounded-lg flex items-center justify-center">
                        <span class="text-primary-900 font-display font-bold text-xl">WH</span>
                    </div>
                    <div>
                        <span class="font-display font-bold text-xl text-white">White House</span>
                        <span class="block text-gold-400 text-sm font-medium -mt-1">Premiere</span>
                    </div>
                </div>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Partner terpercaya untuk properti premium di Indonesia. Kami berkomitmen memberikan layanan terbaik untuk mewujudkan hunian impian Anda.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-primary-800 hover:bg-gold-500 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-primary-800 hover:bg-gold-500 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-primary-800 hover:bg-gold-500 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-primary-800 hover:bg-gold-500 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-display font-semibold text-lg mb-6 text-gold-400">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-gold-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('project') }}" class="text-gray-300 hover:text-gold-400 transition-colors">Project</a></li>
                    <li><a href="{{ route('project') }}" class="text-gray-300 hover:text-gold-400 transition-colors">Katalog Properti</a></li>
                    <li><a href="{{ route('testimoni') }}" class="text-gray-300 hover:text-gold-400 transition-colors">Testimoni & Review</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-gold-400 transition-colors">Contact</a></li>
                </ul>
            </div>
            
            <!-- Property Types -->
            <div>
                <h4 class="font-display font-semibold text-lg mb-6 text-gold-400">Tipe Properti</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-gray-300 hover:text-gold-400 transition-colors">Rumah Mewah</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-gold-400 transition-colors">Apartemen</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-gold-400 transition-colors">Villa</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-gold-400 transition-colors">Penthouse</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-gold-400 transition-colors">Commercial</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h4 class="font-display font-semibold text-lg mb-6 text-gold-400">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-gold-400 mt-1"></i>
                        <span class="text-gray-300">Jl. Sudirman No. 123,<br>Jakarta Pusat 10220</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-phone text-gold-400"></i>
                        <span class="text-gray-300">+62 21 1234 5678</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fab fa-whatsapp text-gold-400"></i>
                        <span class="text-gray-300">+62 812 3456 7890</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-gold-400"></i>
                        <span class="text-gray-300">info@whitehousepremiere.com</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Bottom Footer -->
    <div class="border-t border-primary-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} White House Premiere. All rights reserved.
                </p>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-gray-400 hover:text-gold-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-gold-400 transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-gold-400 transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
