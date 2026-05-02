<div
    id="deleteConfirmModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/30 backdrop-blur-sm px-4"
>
    <div class="absolute inset-0" onclick="closeDeleteModal()"></div>

    <div class="relative w-full max-w-[340px] bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.18)] p-5">
        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[24px]">delete</span>
        </div>

        <h2 class="text-[18px] font-bold text-gray-900 mb-2">
            Confirm Delete
        </h2>

        <p id="deleteConfirmMessage" class="text-[14px] leading-6 text-gray-600 mb-5">
            Are you sure you want to delete this item?
        </p>

        <div class="flex justify-end gap-2">
            <button
                type="button"
                onclick="closeDeleteModal()"
                class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition"
            >
                Cancel
            </button>

            <button
                type="button"
                onclick="confirmDeleteAction()"
                class="px-4 py-2 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition"
            >
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<script>
    let deleteTargetForm = null;

    function openDeleteModal(form, message) {
        deleteTargetForm = form;

        const modal = document.getElementById('deleteConfirmModal');
        const messageElement = document.getElementById('deleteConfirmMessage');

        if (messageElement) {
            messageElement.textContent = message || 'Are you sure you want to delete this item?';
        }

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteConfirmModal');

        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        deleteTargetForm = null;
    }

    function confirmDeleteAction() {
        if (deleteTargetForm) {
            deleteTargetForm.submit();
        }
    }
</script>
