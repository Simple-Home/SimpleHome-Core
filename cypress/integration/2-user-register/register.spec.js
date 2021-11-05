describe('User register', () => {
    it('register admin user', () => {
        cy.visit('/register')
        cy.get('#name').clear().type('admin')
        cy.get('#email').clear().type('admin@simplehome.com')
        cy.get('#password').clear().type('admin123456')
        cy.get('#password-confirm').clear().type('admin123456')
        cy.get('.card-body form').submit()
        cy.url().should('include', '/email/verify')
    })

    it('resend email', () => {
        cy.get('.card-body button[type="submit"]').click()
        cy.url().should('include', '/email/resend')
    })
})
