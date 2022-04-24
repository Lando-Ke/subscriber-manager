<template>
    <div class="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
        {{ errors }}
    </div>

    <form class="space-y-6" v-on:submit.prevent="saveSubscriber">
        <div class="space-y-4 rounded-md shadow-sm">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="subscriber.name">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input type="text" name="email" id="email"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="subscriber.email_address">
                </div>
            </div>

            <div>
                <label for="state_id" class="block text-sm font-medium text-gray-700">State</label>
                <div class="mt-1">
                    <select v-model="subscriber.state_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option v-for="option in options" :value="option.value">
                            {{ option.text }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent ring-gray-300 transition duration-150 ease-in-out hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
            Save
        </button>
    </form>
</template>

<script>
    import useSubscribers from '../../composables/subscribers'
    import { onMounted } from 'vue';

    export default {
        data() {
            return {
                selected: 'active',
                options: [
                    { text: 'active', value: 1 },
                    { text: 'unsubscribed', value: 2 },
                    { text: 'junk', value: 3 },
                    { text: 'bounced', value: 4 },
                    { text: 'unconfirmed', value: 5 },
                ]
            }
        },
        props: {
            id: {
                required: true,
                type: String
            }
        },

        setup(props) {
            const { errors, subscriber, updateSubscriber, getSubscriber } = useSubscribers();

            onMounted(() => getSubscriber(props.id));

            const saveSubscriber = async () => {
                await updateSubscriber(props.id)
            };

            return {
                errors,
                subscriber,
                saveSubscriber
            }
        }
    }
</script>
