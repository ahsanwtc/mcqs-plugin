import { TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow } from '@wordpress/components';
import { InspectorControls, BlockControls, AlignmentToolbar } from '@wordpress/block-editor';
import { ChromePicker } from 'react-color';

import './index.scss';

(() => {
  let locked = false;
  
  wp.data.subscribe(() => {
    const blocks = wp.data.select('core/block-editor').getBlocks().filter(block =>
      block.name === 'mcqs-plugin/mcqs' && block.attributes.correct === undefined
    );
    
    if (blocks.length && locked === false) {
      locked = true;
      wp.data.dispatch('core/editor').lockPostSaving('noanswer');
    }

    if (!blocks.length && locked) {
      locked = false;
      wp.data.dispatch('core/editor').unlockPostSaving('noanswer');
    }

    console.log(blocks);

  });

})();

const EditComponent = props => {
  const { setAttributes, attributes: { question, answers, correct, color, alignment }} = props;

  const handleAnswerOnChange = (answer, index) => {
    const newAnswers = answers.concat([]);
    newAnswers[index] = answer;
    setAttributes({ answers: newAnswers });
  };

  const handleDeleteButtonOnClick = index => {
    const newAnswers = answers.filter((_, i) => i !== index);
    setAttributes({ answers: newAnswers });

    if (index === correct) {
      setAttributes({ correct: undefined });
    }
  };

  const handleMarkButtonOnClick = index => setAttributes({ correct: index });
  
  const options = answers.map((answer, index) => {
    return (
      <Flex key={index}>
        <FlexBlock>
          <TextControl value={answer} onChange={ans => handleAnswerOnChange(ans, index)} autoFocus={answer === undefined} />
        </FlexBlock>
        <FlexItem>
          <Button onClick={() => handleMarkButtonOnClick(index)}>
            <Icon className="mark-as-correct" icon={correct === index ? 'star-filled' : 'star-empty'} />
          </Button>
        </FlexItem>
        <FlexItem>
          <Button isLink className="attention-delete" onClick={() => handleDeleteButtonOnClick(index)}>Delete</Button>
        </FlexItem>
      </Flex>
    );
  });

  return (
    <div className="mcqs-edit-block" style={{ backgroundColor: color }}>
      <BlockControls>
        <AlignmentToolbar value={alignment} onChange={a => setAttributes({ alignment: a })} />
      </BlockControls>
      <InspectorControls>
        <PanelBody title="Background Color" initialOpen>
          <PanelRow>
            <ChromePicker color={color} onChangeComplete={c => setAttributes({ color: c.hex })} disableAlpha />
          </PanelRow>
        </PanelBody>
      </InspectorControls>
      <TextControl label="Question:" style={{ fontSize: '20px' }} value={question} onChange={question => setAttributes({ question })} />
      <p style={{ fontSize: '13px', margin: '20px 0 8px 0' }}>Answers:</p>
      {options}
      <Button isPrimary onClick={() => setAttributes({ answers: [...answers, undefined] })}>Add another answer</Button>
    </div>
  );

};

wp.blocks.registerBlockType('mcqs-plugin/mcqs', {
  title: 'MCQs',
  icon: 'smiley',
  category: 'common',
  attributes: {
    question: { type: 'string' },
    answers: { type: 'array', default: [''] },
    correct: { type: 'number', default: undefined },
    color: { type: 'string', default: '#EBEBEB' },
    alignment: { type: 'string', default: 'left' }
  },
  description: 'A simple multiple choice questions plugin.',
  example: {
    attributes: {
      question: 'What is my name?',
      answers: ['Doggo', 'Mewmew', 'jsan'],
      correct: 2,
      alignment: 'left',
      color: '#CFE8F1'
    }
  },
  edit: EditComponent,
  save: () => (null)
});