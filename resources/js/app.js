// ⚠️ استيراد Alpine من Livewire هو المفتاح
import { Alpine, Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

// استيراد الإضافات
import collapse from '@alpinejs/collapse';
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts';
import './echo';

// ✅ تأكد من تحميل الإضافات قبل أي شيء
Alpine.plugin(collapse);
Alpine.plugin(ToastComponent);

// ✅ جعل Alpine متاحًا عالميًا
window.Alpine = Alpine;

// ✅ بدء Livewire (يبدأ Alpine تلقائيًا)
Livewire.start();
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
