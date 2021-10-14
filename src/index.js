wp.blocks.registerBlockType('mcqs-plugin/mcqs', {
  title: 'MCQs',
  icon: 'smiley',
  category: 'common',
  attributes: {
    sky: {
      type: 'string',
    },
    grass: {
      type: 'string',
    }
  },
  edit: props => {
    const { attributes: { sky, grass }} = props;

    const updateSkyColor = e => {
      props.setAttributes({ sky: e.target.value });
    };

    const updateGrassColor = e => {
      props.setAttributes({ grass: e.target.value });
    };

    return (
      <div>
        <input type="text" placeholder="sky color" value={sky} onChange={updateSkyColor} />
        <input type="text" placeholder="grass color" value={grass} onChange={updateGrassColor} />
      </div>
    );
  },
  save: props => {
    const { attributes: { sky, grass }} = props;

    return (
      <p>Today sky is {sky} and the grass is {grass}.</p>
    );
  }
});