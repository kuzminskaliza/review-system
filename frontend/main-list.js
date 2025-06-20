import { createApp } from 'vue';
import ReviewList from './components/ReviewList.js';

createApp({
    components: { ReviewList },
    template: `
      <h1>Схвалені відгуки</h1>
      <ReviewList/>
    `,
}).mount('#app');