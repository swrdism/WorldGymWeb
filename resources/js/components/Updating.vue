<template>

    <div v-if="isUpdating">
        <p>
            Updating Data Now
            {{isUpdating}}
        </p>
    </div>

</template>

<script>

    const axios = require('axios');
    let isUpdating;

    axios.get('http://localhost/api/getIsUpdating').then(function (response) {
        isUpdating = response.data;

    }).catch(function (error) {
        console.log(error);
    });

    export default {
        data () {
            return {
                isUpdating:isUpdating
            }
        },
    }
</script>

