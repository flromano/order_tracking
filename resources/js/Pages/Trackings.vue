<template>
    <c-adoorei-layout>
        <!-- title -->
        <div class="container mx-0 lg:mx-auto px-1 flex items-center flex-wrap lg:justify-between ">
            <div class="min-w-80 pb-4">
                <div class="text-2xl font-extrabold uppercase">Rastreamento de ecomendas</div>
                <div class="text-md">Aconpanhe seus pacotes enviados em tempo real</div>
            </div>
            <div>
                <c-button class="mr-4 mb-4" @click="create = !create">Cadastrar Código</c-button>
                <c-button>Atualizar Código</c-button>
            </div>
        </div>

        <!--tabela de códigos-->
        <div class="container flex flex-col">
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full ">
                    <div class="overflow-hidden">
                        <table class="min-w-full ">
                            <thead >
                            <tr class="border-b-2 border-gray-300 border-dotted">
                                <th scope="col" class="px-6 py-3 text-left text-sm font-black uppercase tracking-wider">Código</th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-black uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-black uppercase tracking-wider">Última Atualização</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Abrir Rastreamento</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="border-b-2 border-gray-300 border-dotted  h-18">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    SR101010BR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> Postado </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    20/12/2022 - 15:50 - Saiu para entrega
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="cursor-pointer" @click="tracking=!tracking">
                                        <img src="images/delivery-truck.svg" />
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--cadastrar código-->
        <c-modal :show="create" max-width="lg">
            <div class="uppercase font-bold text-sm">Cadastrar Código</div>
            <div>Informe o código de rastreio que deseja acompanhar</div>
            <c-input class="my-3" :model-value="code" placeholder="Código"/>
            <div class="flex justify-center">
                <c-button @click="create = !create">Monitorar</c-button>
            </div>
        </c-modal>

        <!--acompanhar código-->
        <c-modal :show="tracking" max-width="xl">
            <div class="container flex justify-between">
                <div class="uppercase font-bold text-sm">Rastreamento - SM101010BR</div>
                <div class="cursor-pointer h-5 w-5" @click="tracking=!tracking">
                    <img src="images/close.svg" alt="Fechar">
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
    data () {
        return {
            create: false,
            tracking: false,
            code: null
        }
    },
    components: { CAdooreiLayout, CButton, CModal, CInput }
}
</script>

<style scoped>
</style>
