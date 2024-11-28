<template>
    <!-- Модальное окно -->
    <div id="messageSystemModal" aria-hidden="true" aria-labelledby="messageSystemModalLabel" class="modal fade" tabindex="-1">
        <div :class="{'modal-lg': wide}" class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="messageSystemModalLabel" class="modal-title">{{ header }}</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    {{ text }}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Message",
    data() {
        return {
            modal : null,
            header: 'Системное сообщение',
            text  : 'Информация',
            wide  : false
        }
    },
    methods: {},
    mounted() {
        var messageSystemModal = document.getElementById('messageSystemModal')
        this.modal             = bootstrap.Modal.getOrCreateInstance(messageSystemModal);
    }
}
</script>

<style scoped>
.modal-body {
    padding : 15px;
}
</style>
