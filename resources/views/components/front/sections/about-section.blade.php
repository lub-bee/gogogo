<header class='bg-slate-700 text-white'>
    About US
</header>

<div class='flex-1 flex flex-col divide-y-4 divide-slate-700 w-2/3 mx-auto justify-center' x-data="{mode: '1'}">

    <div class='' x-data="{open: false}">
        <div class='text-4xl py-2 font-bold uppercase flex gap-4 items-center' @click="mode = (mode == 1)?'false':'1'">
            <i class='fa-solid fa-caret-right transition-all' :class="mode=='1' ? 'fa-rotate-90' : ''"></i>
            <div class='flex-1'>
                五語Go, what is it?
            </div>
            <div class='text-slate-500 text-2xl'>
                五語Goって何ですか?
            </div>
        </div>

        <div class='text-2xl uppercase py-4' x-show="mode == '1'">
            <div class=''>
                It's a study group for people<br/>to learn English or Japanese
            </div>

            <div class='mt-4 text-right text-slate-500'>
                英語や日本語を学ぶための勉強会です。
            </div>
        </div>
    </div>

    <div class=''>
        <div class='text-4xl py-2 font-bold uppercase flex items-center gap-4' @click="mode = (mode == 2)?'false':'2'">
            <i class='fa-solid fa-caret-right transition-all' :class="mode=='2' ? 'fa-rotate-90' : ''"></i>
            <div class='flex-1 -tracking-[0.08em]'>
                How does it works?
            </div>
            <div class='text-slate-500 text-2xl'>
                どうやって機能しますか？
            </div>
        </div>

        <div class='text-2xl mx-auto grid grid-cols-2 items-center divide-x-4 divide-slate-700 py-4' x-show="mode == '2'">
            <div class='text-[9rem] uppercase font-bold -tracking-[0.12em] px-4 text-right'>we</div>
            <div class='flex flex-col uppercase px-4'>
                <div class=''>meet <b>every week</b></div>
                <div class=''>talk <b>5 min</b> in <b>english</b></div>
                <div class=''>talk <b>5 min</b> in <b>japanese</b></div>
                <div class=''>repeat that for <b>30min</b></div>
            </div>
        </div>
        <div class='text-2xl mx-auto grid grid-cols-2 items-center divide-x-4 divide-slate-700 py-4' x-show="mode == '2'">
            <div class='text-[7rem] uppercase font-bold -tracking-[0.12em] px-4 text-right'>私たち</div>
            <div class='flex flex-col uppercase px-4'>
                <div class=''>は<b>毎週</b>会います</div>
                <div class=''>は<b>英語</b>で<b>5分</b>話します</div>
                <div class=''>は<b>日本語</b>で<b>5分</b>話します</b></div>
                <div class=''>は<b>30分</b>間繰り返します</div>

            </div>
        </div>
    </div>

    <div class=''>
        <div class='text-4xl py-2 font-bold uppercase flex gap-4' @click="mode = (mode == 3)?'false':'3'">
            <i class='fa-solid fa-caret-right transition-all' :class="mode=='3' ? 'fa-rotate-90' : ''"></i>
            <div class='flex-1'>
                That's all?
            </div>
            <div class='text-slate-500 text-2xl'>
                それだけですか？
            </div>
        </div>
        <div class='' x-show="mode == '3'">

            <div class='flex justify-between'>
                <div class='text-2xl uppercase'>
                    <b>No!</b><br/>
                    We also do BBQs,<br/> festivals,<br/> sports activities,<br/> and much much more!
                </div>
                <div class='text-2xl text-right uppercase text-slate-500' x-show="mode == '3'">
                    <b>違います!</b><br/>
                    バーベキュー<br/>
                    やお祭り、<br/>スポーツ活動など、<br/>もっとたくさんのことを行っています！
                </div>
            </div>
            <div class='text-center mt-8'>
                <a href="#media" class="btn btn-danger">Take a look!</a>
            </div>
        </div>
    </div>

</div>
