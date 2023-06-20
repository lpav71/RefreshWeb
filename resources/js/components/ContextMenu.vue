<template>
<transition name="fade" mode="out-in">
    <div class="context-menu" v-show="showMenu" :style="{left: left + 'px', top: top + 'px', width: width + 'rem'}">
        <ul>
            <li @click="selectItem(i)" v-for="(m,i) in menu" :key="i">{{ m }}</li>
        </ul>
    </div>
</transition>
</template>

<script>

export default {
    name: "ContextMenu",
    data(){
        return {
            menu: [],
            showMenu: false,
            left: 10,
            top: 10,
            width: 20,
            index: null,
            element: null,
            event: null
        }
    },
    methods: {
        show() {
            const longestWord = this.menu.reduce((a, b) => {
                return a.length > b.length ? a : b;
            });
            const lengthOfLongestWord = longestWord.length;
            this.width = lengthOfLongestWord;
            var rightBoundary = this.event.pageX - this.event.offsetX;
            var topBoundary = this.event.pageY - this.event.offsetY;
            this.left = rightBoundary - 76;
            this.top = topBoundary - 500;
            this.showMenu = true;
        },
        hide() {
            this.showMenu = false;
        },
        selectItem(item) {
            this.$emit('item-selected', item);
        }
    },
    mounted() {
    }
}
</script>

<style scoped lang="scss">
.context-menu {
    ul {
        li{
            padding: 5px;
            border-radius: 5px;
        }
        li:hover{
            background: var(--light-blue-bg-color);
            color: var(--standart-gray);
        }
        list-style: none;
        padding: 11px;
        cursor: pointer;
    }
    background: var(--light-blue-menu-color);
    position: relative;
    border-radius: 10px;
}

.fade-enter-active, .fade-leave-active {
    transition: all 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
    transform: scale(0.8);
}
</style>
