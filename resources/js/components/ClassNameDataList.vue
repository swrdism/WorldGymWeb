<template>

    <div v-if="refactor">
        <div v-for="category in refactor.list">
            <input type="checkbox" :id="category" :value="category" v-model="classSwitch">
            <label for="name">{{category}}</label>
            <br>
            <span  v-for=" name  in refactor.map[category].list">
                <input type="checkbox" :id="name" :value="name" v-model="className">
                <label for="name">{{name}}</label>
            </span>
            <br>
        </div>
        <span>Checked names: {{ className }}</span>
    </div>

</template>

<script>

    const axios = require('axios');

    export default {
        data () {
            return {
                rawData:null,
                classNameDataList:null,
                className:[],
                classSwitch:[]
            }
        },
        mounted () {
            axios
                .get('http://localhost/api/getClassNameDataList')
                .then(response => (this.classNameDataList = response.data))
                .catch(function (error) {
                    console.log(error);
                });
        },
        computed:{
            refactor(){
                if (this.classNameDataList !== null) {
                    let obj =
                        {
                            list: [],
                            map: {}
                        }
                    this.classNameDataList.forEach(({name, category}) => {
                        if (!obj.list.includes(category)) {
                            obj.list.push(category);
                            obj.map[category] = {
                                list: []
                            }
                        }
                        obj.map[category].list.push(name);
                    })
                    return obj;
                }else{
                    return null;
                }
            },
            classSwitch:

        }

    }
</script>

