<script>
    console.log(' ATTACK SCRIPT LOADED');
</script>
<div id="attackOverlay" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm">
    <img id="attackOverlayGif" src="" alt="attack" class="w-full max-w-lg rounded-xl shadow-2xl">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        console.log('[ATTACK] script loaded');

        const forms = document.querySelectorAll('.attack-form');

        console.log('[ATTACK] forms found:', forms.length);

        forms.forEach((form, index) => {

            console.log('[ATTACK] binding form', index, form.dataset);

            form.addEventListener('submit', function (event) {

                console.log('[ATTACK] submit triggered');

                const gif = this.dataset.gif;
                const duration = Number(this.dataset.duration);

                console.log('[ATTACK] gif:', gif);
                console.log('[ATTACK] duration:', duration);

                if (!gif) {
                    console.log('[ATTACK] no gif -> normal submit');
                    return;
                }

                event.preventDefault();

                const overlay = document.getElementById('attackOverlay');
                const img = document.getElementById('attackOverlayGif');

                console.log('[ATTACK] overlay:', overlay);
                console.log('[ATTACK] img:', img);

                if (!overlay || !img) {
                    console.error('[ATTACK] overlay or img missing');
                    return;
                }

                img.src = '';
                img.src = `/gifs/${gif}.gif`;

                console.log('[ATTACK] gif set:', img.src);

                overlay.classList.remove('hidden');
                overlay.classList.add('flex');

                const minDuration = 7000; 
                const finalDuration = Math.max(duration || 0, minDuration);

                setTimeout(() => {
                    console.log('[ATTACK] hiding overlay + submitting form');

                    overlay.classList.remove('flex');
                    overlay.classList.add('hidden');

                    this.submit();

                }, finalDuration);
            });
        });
    });
</script>