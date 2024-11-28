<template>
    <transition mode="out-in" name="fade">
        <div v-show="showMenu" :style="{left: left + 'px', top: top + 'px', width: width + 'rem'}" class="context-menu">
            <div v-show="showHeader" :style="{width: width + 'rem'}" class="header">{{ headerText }}</div>
            <ul>
                <li v-for="(m,i) in menu" :key="i" @click="selectItem(i)">{{ m }}</li>
            </ul>
        </div>
    </transition>
</template>

<script>

export default {
    name: "ContextMenu",
    data() {
        return {
            menu      : [],
            showMenu  : false,
            left      : 10,
            top       : 10,
            width     : 20,
            index     : null,
            element   : null,
            event     : null,
            headerText: '',
            showHeader: false
        }
    },
    methods: {
        show() {
            const longestWord         = this.menu.reduce((a, b) => {
                return a.length > b.length ? a : b;
            });
            const lengthOfLongestWord = longestWord.length;
            this.width                = lengthOfLongestWord;
            var rightBoundary         = this.event.pageX - 100;
            var topBoundary           = this.event.pageY - 100;
            this.left                 = rightBoundary;
            this.top                  = topBoundary;
            this.showHeader           = (this.headerText != 'ID null' && this.headerText != '');
            this.showMenu             = true;
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

<style lang="scss" scoped>
.context-menu {
    background    : var(--light-blue-menu-color);
    position      : absolute;
    border-radius : 10px;
    overflow      : hidden;

    .header {
        background  : linear-gradient(180deg, #43738a 0%, #24566f 100%);
        height      : 30px;
        position    : relative;
        top         : 0;
        left        : 0;
        text-align  : center;
        padding-top : 4px;
        color       : var(--standart-gray);
    }

    ul {
        li {
            padding       : 5px;
            border-radius : 5px;
        }

        li:hover {
            background : var(--light-blue-bg-color);
            color      : var(--standart-gray);
        }

        list-style : none;
        padding    : 11px;
        cursor     : pointer;
    }
}

.fade-enter-active, .fade-leave-active {
    transition : all 0.5s;
}

.fade-enter, .fade-leave-to {
    opacity   : 0;
    transform : scale(0.8);
}
</style>
