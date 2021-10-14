wp.blocks.registerBlockType('mcqs-plugin/mcqs', {
  title: 'MCQs',
  icon: 'smiley',
  category: 'common',
  edit: () => {
    return wp.element.createElement('h3', null, 'Hello this is from admin editor screen');
  },
  save: () => {
    return wp.element.createElement('h3', null, 'Hello this is frontend');
  }
});