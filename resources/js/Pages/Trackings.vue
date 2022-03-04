<template>
    <c-adoorei-layout>
        <!-- title -->
        <div class="container mx-0 lg:mx-auto px-1 flex items-center flex-wrap lg:justify-between ">
            <div class="min-w-80 pb-4">
                <div class="text-2xl font-extrabold uppercase">Rastreamento de ecomendas</div>
                <div class="text-md">Aconpanhe seus pacotes enviados em tempo real</div>
            </div>
            <div>
                <c-button class="mr-4 mb-4" @click="onCreated">Cadastrar Código</c-button>
                <c-button @click="onUpdated">Atualizar Códigos</c-button>
            </div>
        </div>

        <!-- filtro de status -->
        <div class="container flex my-4 w-full">
            <select class="border border-gray-300 text-sm pl-4 pr-10 py-2 text-gray-700 focus:outline-none focus:border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm sm:ml-auto w-auto" v-model="filter">
                <option>Todos</option>
                <option>Aguardando Postagem</option>
                <option>Postados</option>
                <option>Em Trânsito</option>
                <option>Saiu para Entrega</option>
                <option>Retirada</option>
                <option>Entregue</option>
                <option>Devolvido</option>
            </select>
        </div>

        <!--tabela de códigos-->
        <div class="container flex flex-col mt-4">
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full ">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                            <tr class="border-b-2 border-gray-300 border-dotted">
                                <th scope="col" class="px-6 py-3 text-left text-sm font-black uppercase tracking-wider">
                                    Código
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-black uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-black uppercase tracking-wider">
                                    Última Atualização
                                </th>
                                <th scope="col" class="relative px-6 py-3"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="tracking in trackings" :key="tracking.id"
                                class="border-b-2 border-gray-300 border-dotted h-18">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ tracking.code }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> {{
                                            tracking.status
                                        }} </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span v-if="tracking.last_update">{{
                                            tracking.last_update.date
                                        }} {{ tracking.last_update.time }} - {{ tracking.last_update.status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button type="button" @click="onOpen(tracking.id)" class="h-10 w-10">
                                        <img src="images/delivery-truck.svg" class="m-1"/>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!trackings.length">
                                <td colspan="4" class="pt-4 text-gray-600">Nenhum código cadastrado</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--cadastrar código-->
        <c-modal :show="openModalCreate" max-width="lg">
            <div class="uppercase font-bold text-sm">Cadastrar Código</div>
            <div>Informe o código de rastreio que deseja acompanhar</div>
            <form method="post" @submit.prevent="onStored">
                <c-input class="my-3" v-model="form.code" placeholder="Código"/>
                <div v-if="form.errors.code" class="text-sm text-red-600 mb-4">{{ form.errors.code }}</div>
                <div class="flex justify-center">
                    <c-button>Monitorar</c-button>
                </div>
            </form>
        </c-modal>

        <!--acompanhar código-->
        <c-modal :show="openModelTracking">
            <div class="container flex justify-between">
                <div class="uppercase font-bold text-sm">Rastreamento - {{ trackingData.code }}</div>
                <div class="cursor-pointer h-5 w-5" @click="openModelTracking=!openModelTracking">
                    <img src="images/close.svg" alt="Fechar">
                </div>
            </div>
            <div class="container flex flex-col mt-4">
                <div class="overflow-x-auto">
                    <div class="align-middle inline-block min-w-full ">
                        <div class="overflow-hidden">
                            <table class="min-w-full">
                                <tbody>
                                    <tr v-for="tracking in trackingData.tracking" :key="tracking.id"
                                        class="border-b-2 border-gray-300 border-dotted h-18 text-sm">
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ tracking.date }} {{ tracking.time }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ tracking.city }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ tracking.status }}
                                        </td>
                                    </tr>
                                    <tr v-if="!trackingData.tracking.length">
                                    <td colspan="3" class="pt-4 text-gray-600">Objeto aguardando postagem</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </c-modal>

    </c-adoorei-layout>
</template>

<script>
import CAdooreiLayout from "../Layouts/AdooreiLayout";
import CButton from "../Jetstream/Button"
import CModal from "../Jetstream/Modal";
import CInput from "../Jetstream/Input";

export default {
    name: "Index",
    data() {
        return {
            openModalCreate: false,
            openModelTracking: false,
            trackingData: null,
            filter: 'Todos',
            form: this.$inertia.form({
                code: null
            })
        }
    },
    components: {CAdooreiLayout, CButton, CModal, CInput},
    computed: {
        trackings () {
            if (this.filter === 'Todos') {
                return this.$page.props.trackings
            }
            return this.$page.props.trackings.filter((item) => {
                return item.status === this.filter
            })

        }
    },
    methods: {
        onCreated() {
            this.form.clearErrors()
            this.openModalCreate = !this.openModalCreate
        },
        onStored() {
            this.form.post('/', {
                preserveScroll: true,
                onSuccess: () => {
                    this.openModalCreate = !this.openModalCreate
                    this.form.code = null
                },
            })

        },
        onUpdated() {
            this.$inertia.put('/')
        },
        onOpen(id) {
            this.trackingData = this.findTracking(id)
            this.openModelTracking = !this.openModelTracking
        },
        findTracking(id) {
            return this.$page.props.trackings.find((item) => {
                return item.id === id
            })
        }
    }
}
</script>

<style scoped>
</style>
