import Hooks from './EditorComponents/Hooks';

export default class Editor {
  constructor() {
    Hooks.run();
  }
}

new Editor();
