const aboutCardsData = [
  {
    title: 'Built for the End',
    copy: 'Every tool, weapon, and kit we sell is designed to keep you alive when the world stops making sense. Dependable gear for the worst days.',
    img: './assets/img/about-card-image-1.jpg'
  },
  {
    title: 'Supplies When You Need Them',
    copy: 'We make sure you can get food, water, medicine, and weapons fast—even when roads are ruined and comms are down. Survival should never be out of reach.',
    img: './assets/img/about-card-image-2.png'
  },
  {
    title: 'Gear for Every Threat',
    copy: 'Whether you’re fighting off raiders or patching up wounds, our selection covers it all. Pick what suits your plan and stay one step ahead.',
    img: './assets/img/about-card-image-3.jpeg'
  },
  {
    title: 'Always One Step Ahead',
    copy: 'The apocalypse keeps changing. So do we. Count on us to keep updating our stock with what really works out there.',
    img: './assets/img/about-card-image-4.png'
  }
];

const aboutGrid = document.getElementById('about-cards-grid');
aboutCardsData.forEach(card => {
  const div = document.createElement('div');
  div.className = 'col-12 col-sm-6 col-lg-3 d-flex';
  div.innerHTML = `
    <div class="about-card" style="background-image: url('${card.img}');">
      <div class="about-card-content">
        <h2 class="about-card-title">${card.title}</h2>
        <p class="about-card-copy">${card.copy}</p>
      </div>
    </div>
  `;
  aboutGrid.appendChild(div);
});
