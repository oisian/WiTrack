<template>
    <div class="panel panel-default">
        <div class="panel-heading text-center">Past movements
        </div>
        <div class="panel-body">

            <b-list-group>
                <div v-for="item in uniqueHosts">
                    <b-list-group-item v-b-toggle="item">
                        {{item}}
                        <b-collapse :id="item" class="mt-2">
                            <table class="table table-striped">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Reported From</th>
                                    <th scope="col">Mac Address</th>
                                    <th scope="col">Wifi Type</th>
                                    <th scope="col">Frequency</th>
                                    <th scope="col">Signal Strength</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="p in deviceData">
                                        <template v-if="p.mac == item">
                                            <td>{{ p['reportedFrom'] }}</td>
                                            <td>{{ p['mac'] }}</td>
                                            <td>{{ p['type'] }}</td>
                                            <td>{{ p['frequency'] }}</td>
                                            <td>{{ p['signalStrength'] }}Dbm</td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </b-collapse>
                    </b-list-group-item>
                </div>
            </b-list-group>
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                deviceData: this.deviceData,
                uniqueHosts: this.uniqueHosts
            }
        },
        created() {
            this.getDeviceData();
            setInterval(function () {
                this.getDeviceData();
                this.getUniqueHosts()
            }.bind(this), 3750);
        },
        methods: {
            getDeviceData() {
                window.axios.get('api/v1/track/getdevices')
                    .then((response) => {
                        this.deviceData = response.data;
                    })
                    .catch((error) => {
                            if (error.response) {
                                console.log(error.response);
                            } else {
                                console.log('Error', error.message);
                            }
                            console.log(error.config);
                        }
                    );
            },

            getUniqueHosts() {
                let unique = [...new Set(this.deviceData.map(item => item.mac))];
                this.uniqueHosts = unique;
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
