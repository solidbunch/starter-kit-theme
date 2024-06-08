import Hooks from './EditorComponents/Hooks';
import Events from './EditorComponents/Events';

export default class Editor {
  constructor() {
    Hooks.run();
    Events.run();
  }
}

new Editor();
