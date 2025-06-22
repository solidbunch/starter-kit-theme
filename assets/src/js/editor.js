import Hooks from './EditorComponents/Hooks';
import Events from './EditorComponents/Events';

export default class Editor {
  constructor() {
    // Run Gutenberg blocks hooks
    Hooks.run();

    // Run Gutenberg blocks events
    Events.run();
  }
}

new Editor();
