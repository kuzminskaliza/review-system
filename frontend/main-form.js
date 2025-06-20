import { createApp } from 'vue';
import ReviewForm from './components/ReviewForm.js';

createApp({
    components: { ReviewForm },
    template: `
      <h1>Залиште відгук</h1>
      <ReviewForm/>
    `,
}).mount('#app');