<template>
    <div>
        <label>
            <slot></slot>
        </label>
        <input v-model="inputData" :placeholder="label" :style="{width: width + 'px'}" class="div_4 span-1">
    </div>
</template>

<script>
export default {
    name: "Input-text",
    data() {
        return {
            width    : 190,
            label    : '',
            inputData: ''
        }
    },
    methods: {},
    mounted() {
        this.label = this.$slots.default()[0].children;
    }
}
</script>

<style scoped>
label {
    color : var(--standart-gray);
}

.span-1 {
    margin-top : 14px;
    display    : block;
    font-size  : inherit;
}

.div_4 {
    height        : 35px;
    background    : var(--bg);
    padding       : 5px 15px 5px 15px;
    margin-top    : 5px;
    color         : var(--standart-gray);
    border        : none;
    width         : 190px;
    border-radius : 8px;
    font-size     : inherit;
}
</style>
