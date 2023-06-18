<template>
    <!-- Модальное окно -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">{{ header }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    {{ text }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Message",
    data(){
        return{
            modal: null,
            header: 'Системное сообщение',
            text: 'Ошибка'
        }
    },
    methods: {

    },
    mounted() {
        var messageModal = document.getElementById('messageModal')
        this.modal = bootstrap.Modal.getOrCreateInstance(messageModal);
    }
}
</script>

<style scoped>
.modal-body {
    padding: 15px;
}
.modal-content {
    background: var(--danger-bg-color);
}
</style>
