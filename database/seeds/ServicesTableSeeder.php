<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::truncate();

        $service = [
            [
                'title' => 'Bitcoin Mining',
                'description' => '<p style="font-size:24px; font-weight:bold">What is Bitcoin Mining</p><p style="text-align:justify">
                Bitcoin mining is a lot like a giant lottery where you compete with your mining
                hardware with everyone on the network to earn bitcoins. Faster Bitcoin mining hardware
                is able to attempt more tries per second to win this lottery while the Bitcoin network
                itself adjusts roughly every two weeks to keep the rate of finding a winning block hash
                to every ten minutes. In the big picture, Bitcoin mining secures transactions that are
                recorded in Bitcon\'s public ledger, the block chain. By conducting a random lottery
                where electricity and specialized equipment are the price of admission, the cost to
                disrupt the Bitcoin network scales with the amount of hashing power that is being spent
                by all mining participants.</p><p style="font-size:24px; font-weight:bold">What is GB-Forex Mining</p>
                <p style="text-align:justify">GB-Forex Enter in Bitcoin Mining at the end of 2014. They got to know
                each other by using the same platform for buying and selling Bitcoins. GB-Forex company
                and its user base grew, new mining farms were built up and several additional people
                hired, specifically programmers and engineers. The current members of GB-Forex come from
                different scientific disciplines, but our common faith in cryptocurrencies has brought
                us together.GB-Forex strong believers in the future of digital currencies and GB-Forex
                love being part of this growing community! GB-Forex having large number of bitcoin Machine
                on it own farm. GB-Forex Share his Profits to the investor.</p>'
            ],
            [
                'title' => 'Forex Trading',
                'description' => ' <p style="font-size:24px; font-weight:bold">What is Forex Trading</p>
                    <p style="text-align:justify">Essentially, forex trading is the act of simultaneously
                    buying one currency while selling another, primarily for the purpose of speculation.
                    Currency values rise (appreciate) and fall (depreciate) against each other due to a
                    number of factors including economics and geopolitics. The common goal of forex traders
                    is to profit from these changes in the value of one currency against another by
                    actively speculating on which way forex prices are likely to turn in the future.
                    Unlike most financial markets, the OTC (over-the-counter) forex market has no physical
                    location or central exchange and trades 24-hours a day through a global network of
                    businesses, banks and individuals. This means that currency prices are constantly
                    fluctuating in value against each other, offering multiple trading opportunities.</p>
                    <p style="font-size:24px; font-weight:bold">What is GB-Forex Trading</p>
                     <p style="text-align:justify">
                     GB-Forex Trade Responsibly: GB-Forex are complex financial products that are traded
                     on margin. Trading GB-Forex carries a high level of risk since leverage can work both
                     to your advantage and disadvantage. As a result, GB-Forex may suitable for all
                     investors because you may not lose all your invested capital. GB-Forex should not
                     risk more than you are prepared to lose. Before deciding to trade, GB-Forex need to
                     ensure that the risks involved taking into account your investment objectives and
                     level of experience. Past performance of GB-Forex is a reliable indicator of future
                     results. Most GB-Forex have no set maturity date. Hence, a GB-Forex position matures
                     on the date you choose to close an existing open position. Seek independent advice,
                     if necessary. Please read GB-Forex full ‘Risk Disclosure Statement’.</p>
                     <p style="text-align:justify">A relative newcomer to the world of charting platforms,
                     cTrader has already developed a loyal following among traders looking for an added
                     level of market resolution. Designed specifically for the trading of GB-Forex,
                     GB-Forex is a trading platform allowing traders to place orders while having access
                     to full market depth. GB-Forex provides its traders on the GB-Forex trading platform
                     with the best available bid and ask prices, even when they come from competing
                     institutions. We also fill orders at VWAP (Volume-Weighted Average Price),
                     executing through the available liquidity tiers until the order is filled.
                     This enables us to offer some of the tightest trading spreads in the industry,
                     starting from 0 pips on highly liquid pairs.</p> '
            ],
            [
                'title' => 'Gold Trading',
                'description' => '<p style="font-size:24px; font-weight:bold">What is Gold Trading</p>
                    <p style="text-align:justify">economic regions or countries, until recent times.
                    Many European countries implemented gold standards in the latter part of the 19th
                    century until these were temporarily suspended in the financial crises involving
                    World War I. After World War II, the Bretton Woods system pegged the United States
                    dollar to gold at a rate of US$35 per troy ounce. The system existed until the 1971
                    Nixon Shock, when the US unilaterally suspended the direct convertibility of the
                    United States dollar to gold and made the transition to a fiat currency system.
                    The last currency to be divorced from gold was the Swiss Franc in 2000.[citation needed].
                    Since 1919 the most common benchmark for the price of gold has been the London gold fixing,
                    a twice-daily telephone meeting of representatives from five bullion-trading firms of the
                    London bullion market. Furthermore, gold is traded continuously throughout the world based
                    on the intra-day spot price, derived from over-the-counter gold-trading markets around
                    the world (code "XAU"). The following table sets forth the gold price versus various
                    assets and key statistics on the basis of data taken with the frequency of five years.</p>
                    <p style="font-size:24px; font-weight:bold">What is GB-Forex Gold Trading</p>
                    <p style="text-align:justify"> GB-Forex Trade Responsibly: GB-Forex are complex
                    financial products that are traded on margin. Trading GB-Forex carries a high level
                    of risk since leverage can work both to your advantage and disadvantage. As a result,
                    GB-Forex may suitable for all investors because you may not lose all your invested
                    capital. GB-Forex should not risk more than you are prepared to lose. Before deciding
                    to trade, GB-Forex need to ensure that the risks involved taking into account your
                    investment objectives and level of experience. Past performance of GB-Forex is a
                    reliable indicator of future results. Most GB-Forex have no set maturity date.
                    Hence, a GB-Forex position matures on the date you choose to close an existing
                    open position. Seek independent advice, if necessary. Please read GB-Forex full
                    ‘Risk Disclosure Statement’.</p>
                    <p style="text-align:justify">A relative newcomer to the world of charting platforms,
                    cTrader has already developed a loyal following among traders looking for an added
                    level of market resolution. Designed specifically for the trading of GB-Forex,
                    GB-Forex is a trading platform allowing traders to place orders while having access
                    to full market depth. GB-Forex provides its traders on the GB-Forex trading
                    platform with the best available bid and ask prices, even when they come from
                    competing institutions. We also fill orders at VWAP (Volume-Weighted Average Price),
                    executing through the available liquidity tiers until the order is filled.
                    This enables us to offer some of the tightest trading spreads in the industry,
                    starting from 0 pips on highly liquid pairs.</p>'
            ],
        ];

        Service::insert($service);
    }
}
