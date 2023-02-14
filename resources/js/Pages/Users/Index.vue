<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { PropType, ref } from "vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Dropdown from 'primevue/dropdown';
import useRoute from '@/Hooks/useRoute';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import ConfirmPopup from 'primevue/confirmpopup';
import { useConfirm } from "primevue/useconfirm";
import Password from 'primevue/password';
const route = useRoute();
const toast = useToast();
const confirm = useConfirm();

const props = defineProps({
    users: {
        type: Array as PropType<App.Models.User[]>,
        required: true
    },
});

const displayDialog = ref<boolean>(false);
const displayDialogEdit = ref<boolean>(false);
const selecteduser = ref<App.Models.User>();

const form = useForm({
    name: <string | null>"",
    email: <string | null>"",
    password: <string | null>"",
    role: <string | null>""
});

const openDialog = () => {
    resetForm();
    displayDialog.value = true;
};
const closeDialog = () => {
    displayDialog.value = false;
};

const openDialogEdit = () => {
    displayDialogEdit.value = true;
};
const closeDialogEdit = () => {
    displayDialogEdit.value = false;
};

const resetForm = () => {
    form.reset();
}

const submit = () => {
    form.post(route("users.store"), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Message de réussite', detail: 'le Utilisateur a été créé avec succès', life: 3000 });
            resetForm();
            closeDialog();
        },
        onError: () => {
            console.log(form.errors);
        },
        onFinish: () => { },
    });
}

const edit = (data: App.Models.User): void => {
    selecteduser.value = data;
    Object.assign(form, data);
    openDialogEdit();
}
const update = (id) => {
    form.put(route("users.update", { user: id }), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Message de réussite', detail: 'Le utilisateur a été bien modifier', life: 3000 });
            resetForm();
            closeDialogEdit();
        },
        onError: () => {
            console.log(form.errors);
        },
        onFinish: () => { },
    });
}

const destroy = (id, event) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Êtes-vous sur de vouloir continuer?',
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-danger',
        accept: () => {
            //callback to execute when user confirms the action
            form.delete(route("users.destroy", { user: id }), {
                onSuccess: () => {
                    toast.add({ severity: 'info', summary: 'Message de réussite', detail: 'Le utilisateur a été bien supprimer', life: 3000 });
                    resetForm();
                    closeDialogEdit();
                },
                onError: () => {
                    console.log(form.errors);
                },
                onFinish: () => { },
            });
        },
        reject: () => {
            //callback to execute when user rejects the action
        },
    });

}
</script>

<template>

    <Head title="Utilisateurs" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">List des utilisateurs</h2>
        </template>
        <Toolbar>
            <template #start>
                <Button label="Nouveau" icon="pi pi-plus" class="p-button-success mr-2" @click="openDialog()" />
            </template>
        </Toolbar>
        <DataTable showGridlines :value="users" responsiveLayout="scroll" :paginator="true" :rows="4">
            <template #header>
                <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                    <h5 class="mb-2 md:m-0 p-as-md-center">Gérer les utilisateurs</h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText placeholder="Search..." />
                    </span>
                </div>
            </template>
            <Column class="uppercase" field="id" header="id" :sortable="true"></Column>
            <Column class="uppercase" field="name" header="name" :sortable="true"></Column>
            <Column class="uppercase" field="email" header="email" :sortable="true"></Column>
            <Column class="uppercase" field="role" header="role" :sortable="true"></Column>
            <Column class="uppercase" field="created_at" header="created_at" :sortable="true"></Column>
            <Column class="uppercase" field="updated_at" header="updated_at" :sortable="true"></Column>
            <Column class="uppercase" field="action" header="action">
                <template #body="slotProps">
                    <div class="flex flex-col space-y-1">
                        <Button label="Modifier" icon="pi pi-pencil" class="p-button-info uppercase"
                            @click="edit(slotProps.data)" />
                        <Button label="Supprimer" icon="pi pi-trash" class="p-button-danger uppercase"
                            @click="destroy(slotProps.data.id, $event)" />
                    </div>

                </template>
            </Column>
        </DataTable>

        <!-- Create dialog -->
        <Dialog header="Nouveau utilisateur" v-model:visible="displayDialog"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :maximizable="true"
            :modal="true">
            <div class="flex flex-col space-y-2 w-full">
                <div>
                    <label>Nom</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.name" placeholder="Nom" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.name }" />

                    </span>
                    <small class="p-error" v-show="form.errors.name">{{ form.errors.name }}</small>
                </div>
                <div>
                    <label>email</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputText type="text" v-model="form.email" placeholder="email" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.email }" />
                    </span>
                    <small class="p-error" v-show="form.errors.email">{{
                        form.errors.email
                    }}</small>
                </div>
                <div>
                    <label>Role</label>
                    <Dropdown v-model="form.role"
                        :options="[{ roleName: 'administrator' }, { roleName: 'student' }, { roleName: 'teacher' }]"
                        optionLabel="roleName" placeholder="Sélectionnez un Role" :filter="true"
                        filterPlaceholder="Chercher un Role" class="w-full" optionValue="roleName"
                        v-bind:class="{ 'p-invalid': form.errors.role }" />
                    <small class="p-error" v-show="form.errors.role">{{ form.errors.role }}</small>
                </div>
                <div class="flex flex-col">
                    <label>Mot de pass</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <Password v-model="form.password" placeholder="Mot de pass" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.password }" />
                    </span>
                    <small class="p-error" v-show="form.errors.password">{{
                        form.errors.password
                    }}</small>
                </div>
            </div>

            <template #footer>
                <Button label="Annuler" icon="pi pi-times" class="p-button-text" @click="resetForm()" />
                <Button label="Soumettre" icon="pi pi-check" class="p-button-success" autofocus @click="submit()"
                    :loading="form.processing" />
            </template>
        </Dialog>

        <!-- Edit dialog -->
        <Dialog :header="'Modifier le utilisateur ' + form.name" v-model:visible="displayDialogEdit"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :maximizable="true"
            :modal="true">
            <div class="flex flex-col space-y-2 w-full">
                <div>
                    <label>Nom</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.name" placeholder="Nom" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.name }" />

                    </span>
                    <small class="p-error" v-show="form.errors.name">{{ form.errors.name }}</small>
                </div>
                <div>
                    <label>email</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputText type="text" v-model="form.email" placeholder="email" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.email }" />
                    </span>
                    <small class="p-error" v-show="form.errors.email">{{
                        form.errors.email
                    }}</small>
                </div>
                <div>
                    <label>Role</label>
                    <Dropdown v-model="form.role"
                        :options="[{ roleName: 'administrator' }, { roleName: 'student' }, { roleName: 'teacher' }]"
                        optionLabel="roleName" placeholder="Sélectionnez un Role" :filter="true"
                        filterPlaceholder="Chercher un Role" class="w-full" optionValue="roleName"
                        v-bind:class="{ 'p-invalid': form.errors.role }" />
                    <small class="p-error" v-show="form.errors.role">{{ form.errors.role }}</small>
                </div>
            </div>

            <template #footer>
                <Button label="Soumettre" icon="pi pi-check" class="p-button-success" autofocus
                    @click="update(selecteduser?.id)" :loading="form.processing" />
            </template>
        </Dialog>
    </AuthenticatedLayout>
    <ConfirmPopup></ConfirmPopup>
    <Toast />
</template>
<style lang="scss" scoped>
.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    @media screen and (max-width: 960px) {
        align-items: start;
    }

    .sizes {
        .p-inputtext {
            display: block;
            margin-bottom: .5rem;

            &:last-child {
                margin-bottom: 0;
            }
        }
    }

    .field * {
        display: block;
    }
}
</style>
