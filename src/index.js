wp.blocks.registerBlockType('mcqs-plugin/mcqs', {
  title: 'MCQs',
  icon: 'smiley',
  category: 'common',
  edit: () => {
    return (
      <div>
        <p>Hello, this is paragraph</p>
        <h4>Hi there</h4>
      </div>
    );
  },
  save: () => {
    return (
      <React.Fragment>
        <h5>frontend</h5>
        <h2>frontend</h2>
      </React.Fragment>
    );
  }
});