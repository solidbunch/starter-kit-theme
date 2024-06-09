import BlockEvents from './Handlers/BlockEvents';

export default class Events {

  static run() {

    // Set default block to custom paragraph
    BlockEvents.setDefaultBlock('starter-kit/paragraph');

  }

}
