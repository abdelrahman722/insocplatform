<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Header/Navigation لصفحة الهبوط -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo واسم المنصة -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="bg-indigo-600 text-white p-2 rounded-lg">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-gray-900">InSoc</div>
                            <div class="text-xs text-gray-500">المنصة المدرسية</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8 rtl:space-x-reverse">
                    <a href="#features" class="text-gray-700 hover:text-indigo-600 font-medium">المميزات</a>
                    <a href="#programs" class="text-gray-700 hover:text-indigo-600 font-medium">البرامج</a>
                    <a href="#stats" class="text-gray-700 hover:text-indigo-600 font-medium">الإحصائيات</a>
                    <a href="#contact" class="text-gray-700 hover:text-indigo-600 font-medium">تواصل معنا</a>
                </nav>

                <!-- زر الدخول/التسجيل -->
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                            لوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-indigo-600 font-medium text-sm">
                            تسجيل الدخول
                        </a>
                        <!-- إزالة زر التسجيل وترك فقط زر طلب المدرسة -->
                        <a href="{{ route('request.activation') }}" 
                           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                            طلب إضافة مدرستك
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- بقية محتوى الصفحة كما هو... -->
    <!-- Hero Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    البيئة التفاعلية للمدرسة
                    <span class="text-indigo-600">المتكاملة</span>
                </h1>
                <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto">
                    منصة رقمية متكاملة تربط بين المدرسة والمجتمع التعليمي لتحسين التواصل وتسهيل العمليات اليومية
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('request.activation') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-indigo-700 transition transform hover:scale-105">
                        طلب إضافة مدرستك
                    </a>
                    <a href="#features" class="bg-white text-indigo-600 border-2 border-indigo-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-indigo-50 transition">
                        اكتشف المزيد
                    </a>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-4 gap-8" id="stats">
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="text-3xl font-bold text-indigo-600">{{ $totalSchools ?? 0 }}+</div>
                    <div class="text-gray-600 mt-2">مدرسة مشتركة</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="text-3xl font-bold text-indigo-600">{{ $totalPrograms ?? 0 }}</div>
                    <div class="text-gray-600 mt-2">برنامج متكامل</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="text-3xl font-bold text-indigo-600">100%</div>
                    <div class="text-gray-600 mt-2">رضا المدارس</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="text-3xl font-bold text-indigo-600">24/7</div>
                    <div class="text-gray-600 mt-2">دعم فني</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">لماذا تختار InSoc؟</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    حلول متكاملة لجميع احتياجات المدرسة والمجتمع التعليمي
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-comments text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">تواصل محسن</h3>
                    <p class="text-gray-600">
                        تحسين التواصل بين المدرسة وأولياء الأمور من خلال أنظمة متقدمة ومتنوعة
                    </p>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-utensils text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">إدارة مالية ذكية</h3>
                    <p class="text-gray-600">
                        نظام محفظة مالية مراقب مع إدارة المقصف وحسابات دقيقة
                    </p>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-violet-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chart-bar text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">تقارير وإحصائيات</h3>
                    <p class="text-gray-600">
                        تقارير تحليلية شاملة لمساعدة الإدارة في اتخاذ القرارات
                    </p>
                </div>
                
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">سهولة الاستخدام</h3>
                    <p class="text-gray-600">
                        واجهات بسيطة وسهلة الاستخدام تعمل على جميع الأجهزة
                    </p>
                </div>
                
                <div class="bg-gradient-to-br from-red-50 to-pink-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">أمان وخصوصية</h3>
                    <p class="text-gray-600">
                        حماية قصوى للبيانات مع تشفير متقدم وسياسات خصوصية صارمة
                    </p>
                </div>
                
                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="bg-teal-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-sync-alt text-teal-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">تحديثات مستمرة</h3>
                    <p class="text-gray-600">
                        تطوير وتحديث مستمر للمنصة مع إضافة ميزات جديدة باستمرار
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-20 bg-gray-50" id="programs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">البرامج المضمنة</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                 برامج متخصصة تغطي جميع احتياجات المدرسة الحديثة
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($programs ?? [] as $program)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-2">
                        <div class="bg-indigo-600 text-white p-6 text-center">
                            <flux:icon icon="{{ $program['icon'] }}" class="size-12 mb-3 mx-auto" />
                            <h3 class="text-xl font-bold">{{ $program['name'] ?? 'برنامج' }}</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 text-center">{{ $program['description'] ?? 'وصف البرنامج' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-info-circle text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-600">لا توجد برامج متاحة حالياً</h3>
                        <p class="text-gray-500 mt-2">سيتم إضافة البرامج قريباً</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                هل أنت مستعد لتحسين تجربة مدرستك؟
            </h2>
            <p class="text-xl text-indigo-100 mb-10 max-w-2xl mx-auto">
                انضم إلى مدارسنا المتطورة واستمتع بجميع مميزات المنصة مجاناً لمدة تجريبية
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('request.activation') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                    طلب إضافة مدرستك
                </a>
                <a href="#contact" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-indigo-600 transition">
                    تواصل مع فريق الدعم
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 bg-white" id="contact">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">تواصل معنا</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    لدينا فريق دعم مخصص لمساعدتك في أي استفسار أو سؤال
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-gray-50 rounded-xl">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-brands fa-whatsapp text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">واتساب</h3>
                    <p class="text-gray-600">00971561293357</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-xl">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">الهاتف</h3>
                    <p class="text-gray-600">00971566181467</p>
                </div>
                
                <div class="text-center p-6 bg-gray-50 rounded-xl">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">البريد الإلكتروني</h3>
                    <p class="text-gray-600">mhralexx@gmail.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-600 text-white p-2 rounded-lg">
                            <i class="fas fa-school"></i>
                        </div>
                        <h3 class="text-xl font-bold mr-2">InSoc</h3>
                    </div>
                    <p class="text-gray-400">
                        البيئة التفاعلية للمدرسة المتكاملة لتحسين تجربة التعليم
                    </p>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">الروابط</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">الرئيسية</a></li>
                        <li><a href="#features" class="hover:text-white transition">المميزات</a></li>
                        <li><a href="#programs" class="hover:text-white transition">البرامج</a></li>
                        <li><a href="#contact" class="hover:text-white transition">تواصل معنا</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">البرامج</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>NotiFly</li>
                        <li>Smart Canteen</li>
                        <li>EduConnect</li>
                        <li>S.M.C.T</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">تابعنا</h4>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/" class="bg-gray-800 p-2 rounded-full hover:bg-indigo-600 transition ml-4">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-gray-800 p-2 rounded-full hover:bg-indigo-600 transition">
                            <i class="fab fa-x"></i>
                        </a>
                        <a href="#" class="bg-gray-800 p-2 rounded-full hover:bg-indigo-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 InSoc. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>
</div>