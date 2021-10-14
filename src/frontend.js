import React from 'react';
import ReactDOM from 'react-dom';

import "./frontend.scss";

const divsToUpdate = document.querySelectorAll('.paying-attention-update-me');

const Quiz = props => {
  return (
    <div className="paying-attention-frontend">
      Hello from React
    </div>
  );
};

divsToUpdate.forEach(div => {
  ReactDOM.render(<Quiz/>, div);
  // remove the placeholder 
  div.classList.remove('paying-attention-update-me');
});