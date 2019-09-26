require('./bootstrap');

import index from './components/index'


new Vue({
    el: '#app',
    components: { index },
    data:{
        bus:new Vue()
    }
})
