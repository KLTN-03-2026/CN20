<template>
  <div class="detail-wrapper" v-if="news && news.sections">
    <div class="detail-container">

      <h1 class="main-title">{{ news.title }}</h1>

      <div 
        v-for="(sec, index) in news.sections" 
        :key="index"
        class="movie-item"
      >
        <h2>{{ sec.title }}</h2>

        <p v-for="(t, i) in sec.texts" :key="i">
          {{ t }}
        </p>

        <img :src="sec.image" class="detail-img" />
      </div>

    </div>
  </div>
</template>

<script>
import diadao from '@/assets/diadao.jpg'
import amduonglo from '@/assets/amduonglo.jpg'
import kaitokid from '@/assets/kaitokid.png'
import Momiji from '@/assets/Momiji.jpg'
import okita from '@/assets/okita.jpg'
import okitasoshi from '@/assets/okitasoshi.jpg'
import concam from '@/assets/concam.jpg'
import rima from '@/assets/rima.jpg'
import cam from '@/assets/cam.jpg'
import mecam from '@/assets/mecam.jpg'

export default {
  data() {
    return {
      newsList: [
       {
  slug: 'phim-hot-thang-4',
  title: 'Danh sách những bộ phim hot tháng 4 đáng xem nhất',
  sections: [
    {
      title: '1. Địa đạo - Mặt trời trong bóng tối',
      texts: [
        '“Địa Đạo: Mặt Trời Trong Bóng Tối” của đạo diễn Bùi Thạc Chuyên là một trong những phim hot tháng 4 được mong chờ nhất tại rạp Việt. Đây là tác phẩm chiến tranh – lịch sử hiếm hoi được đầu tư hoàn toàn từ nguồn kinh phí xã hội hóa, không sử dụng ngân sách Nhà nước. Bộ phim ra mắt đúng vào dịp kỷ niệm 50 năm Ngày Giải phóng miền Nam, thống nhất đất nước (30/4/1975 – 30/4/2025), hứa hẹn mang đến những thước phim chân thực và đầy cảm xúc về một giai đoạn hào hùng của dân tộc.',
        'Lấy bối cảnh năm 1968, khi cuộc kháng chiến chống Mỹ bước vào giai đoạn cam go, "Địa Đạo: Mặt Trời Trong Bóng Tối" khắc họa chân dung những người du kích Củ Chi kiên cường, sẵn sàng hy sinh để bảo vệ quê hương. Thái Hòa đảm nhận vai Tư Đạp, một nhân vật trung tâm của câu chuyện. Nam diễn viên chia sẻ rằng anh nhận lời tham gia bộ phim không chỉ vì kịch bản xúc động mà còn vì sự kết nối cá nhân – ông ngoại vợ anh từng tham gia chiến đấu tại vùng đất này.',
        'Ngày khởi chiếu: 04-04-2025 Thể loại: Lịch sử Đặt vé xem phim tại: Địa đạo - Mặt trời trong bóng tối',
      ],
      image: diadao
    },

    {
      title: '2. Âm dương lộ',
      texts: [
        'Là một trong những phim hot tháng 4, "Âm Dương Lộ" mang đến trải nghiệm rùng rợn với câu chuyện đầy bí ẩn xoay quanh thế giới tâm linh. Bộ phim theo chân một chàng cử nhân thất nghiệp, vì kế sinh nhai mà nhận công việc đặc biệt – vận chuyển một thi thể nữ giữa đêm khuya về Tây Nguyên. Tuy nhiên, hành trình này nhanh chóng biến thành cơn ác mộng khi anh phải đối mặt với hàng loạt hiện tượng siêu nhiên kỳ bí, những linh hồn oan khuất và cả những sự thật đen tối đằng sau chiếc xe cứu thương anh đang cầm lái.',
        'Với sự tham gia của dàn diễn viên thực lực và nội dung hấp dẫn, "Âm Dương Lộ" hứa hẹn sẽ mang đến bầu không khí kịch tính, ám ảnh người xem từ đầu đến cuối. Nếu bạn yêu thích thể loại kinh dị tâm linh, đây chắc chắn là bộ phim không thể bỏ lỡ trong danh sách phim hot tháng 4. Đừng quên đặt vé tại Metiz Cinema để sẵn sàng bước vào chuyến hành trình rợn tóc gáy này!',
        'Ngày khởi chiếu: 28-03-2025Thể loại: Hài, Kinh dịĐặt vé xem phim tại: Âm dương lộ',
      ],
      image: amduonglo  
    },
]
}, 
{
  slug: 'nhung-chi-tiet-an-tuong-conan-movie-27-ngoi-sao-5-canh-1-trieu-do',
  title: 'Những Chi Tiết Ấn Tượng Của Conan Movie 27: Ngôi Sao 5 Cánh 1 Triệu Đô',
  sections: [
    {
      texts: [
        'Conan Movie 27: Ngôi sao 5 cánh 1 triệu đô là một bộ phim hoạt hình mang đến một trải nghiệm hành động mãn nhãn. Với những pha rượt đuổi nghẹt thở và hiệu ứng hình ảnh ấn tượng chuẩn Hollywood. Phim là một món quà dành tặng cho các fan hâm mộ trung thành của series, những người luôn mong chờ được thấy Conan và các bạn phiêu lưu trong những tình huống nguy hiểm.',
        'Bộ phim lần này chính là sự có mặt của nhiều nhân vật mới vô cùng hấp dẫn. Mang đến cho người xem những tình huống bất ngờ và thú vị. Cùng tìm hiểu xem những nhân vật xuất hiện trong movie lần này chính là ai nhé!',
        'Aoko lần đầu tiên góp mặt.'
      ],
      image: kaitokid  
      
    },
    {
      title: 'Sự thông minh của Momiji',
      texts: [
        'Một nhân vật khác xuất hiện trong "Ngôi sao 5 cánh 1 triệu đô" chính là Momiji Ooka. Ngay từ đầu cô nàng này đã khiến khán giả bất ngờ với khả năng tư duy logic vượt trội. ',
        'Không chỉ là một cô tiểu thư xinh đẹp, Momiji còn sở hữu một bộ óc nhạy bén, giúp cô nhanh chóng khám phá ra những manh mối quan trọng. Cảnh Momiji giải mã những ký tự bí ẩn trên thanh kiếm là một ví dụ điển hình cho thấy trí thông minh của cô nàng không hề thua kém bất kỳ nhân vật nào trong phim.',
      ],
      image: Momiji
    },
     {
      title: 'Cameo bất ngờ từ vũ trụ manga của Gosho Aoyam',
      texts: [
        'Ngoài Magic Kaito, sự xuất hiện của Okita và Onimaru trong "Ngôi sao 5 cánh 1 triệu đô" không chỉ là một easter egg thú vị. Đây không chỉ là điểm cộng dành riêng cho fan của Gosho Aoyama mà còn là một chi tiết khéo léo giúp tăng thêm sức hấp dẫn cho bộ phim.  ',
        'Với khả năng kiếm đạo siêu phàm, Onimaru đã trở thành một "át chủ bài" giúp Conan và Heiji giành chiến thắng. Hơn thế nữa, khán giả còn sẽ được chứng kiến những màn trình diễn đặc sắc giữa hai bộ phim hấp dẫn này.',
      ],
      image: okita
    },
     {
      title: 'Okita Soshi',
      texts: [
        'Cuối cùng nhưng không thể bỏ qua chính là sự xuất hiện của Okita Soshi, kiếm sĩ thiên tài và hậu duệ của chỉ huy Shinsengumi. Đây là một trong những nhân vật được yêu thích nhất trong thế giới Conan. Với kỹ thuật kiếm đạo điêu luyện và kiến thức sâu rộng về lịch sử.',
        'Okita sẽ là một đồng minh đắc lực giúp Conan và Heiji giải quyết vụ án trong Movie 27: Ngôi sao 5 cánh 1 triệu đô lần này. Tuy nhiên, mối quan hệ giữa Okita và Ran cũng là một điểm nhấn thú vị, hứa hẹn sẽ mang đến nhiều tình huống hài hước và lãng mạn',
      ],
      image: okitasoshi
    },
    {
      texts: [
        'Những ai vội vã ra về sau khi bộ phim kết thúc chắc chắn đã bỏ lỡ một trong những tiết lộ gây sốc nhất trong lịch sử Conan. Không chỉ dừng lại ở màn tỏ tình bất thành của Heiji, bộ phim còn hé lộ một bí mật động trời về mối quan hệ giữa gia đình Kudo và Kuroba. ',
        'Khi Yusaku Kudo tiết lộ về người anh em song sinh thất lạc và cảnh quay chuyển sang màn lộ diện của Toichi Kuroba, khán giả như vỡ òa. Liệu đây có phải là manh mối quan trọng dẫn đến việc làm sáng tỏ mối liên hệ giữa Conan và Kaito Kid? Thế nên chuyện quan trọng nhắc lại 3 lần: Đừng rời đi cho tới khi bộ phim hoàn toàn kết thúc nhé các bạn ơi!',
        'Bộ phim Conan Movie 27: Ngôi sao 5 cánh 1 triệu đô hiện tại đang chiếu tại rạp RIO đang nằm trong top sự lựa chọn của nhiều người. Tuy rằng bộ phim có một vài điểm thất vọng khi tập trung quá nhiều vào các cảnh hành động thay vì phá án những những movie bản trước. Nhưng độ hấp dẫn của bộ phim này là không phải bàn cải.  Thế nên đừng quên tận hưởng bộ phim hấp dẫn này nhé! '
      ],
    },
  ]
},
{
  slug: 'con-cam-2024-bung-no',
    title: 'Con Cám 2024: Bùng Nổ Truyền Thông Ngay Từ Những Ngày Đầu',
    sections: [
      {
      texts: [
        'Tấm cám vốn là một câu chuyện dân gian của Việt Nam được đưa vào khá nhiều các dự án điện ảnh. Nhưng đa phần các dự án này đều là những dự án phim chính kịch hoặc phim tình cảm. Thế nhưng trong tháng 8 này, bộ phim Con Cám 2024 theo concept phim kinh dị đã chính thức gây nhiều rúng động từ ngày tung thông tin phim. ',
        'Nội dung chính của bộ phim',
      ],
      image: concam
      
    },
     {
      texts: [
        'Bộ phim lấy bối cảnh từ làng quê cổ Việt Nam trong thời kỳ phong kiến để kể lại câu chuyện Tấm Cám theo một góc nhìn hoàn toàn mới. Không trữ tình và lãng mạn như những thước phim chiếu rạp về nội dung này, Con Cám 2024 khai thác một khía cạnh kinh dị hoàn toàn mới. Giúp khán giả xem phim tận hưởng câu chuyện theo một hướng hoàn toàn chân thật nhất. ',
        'Những chi tiết như gội đầu, trút tép, chặt cau cho đến những chi tiết trả đũa của Tấm sau khi hóa thành hình người thường được lược bỏ để giảm bớt các yếu tố kinh dị. Trong bộ phim lần này, sẽ được khai thác một cách triệt để nhất những sự kiện trên để làm các yếu tố này thêm phần hấp dẫn. Từ đó dẫn người xem đi từ bất ngờ này đến bất ngờ khác cùng những tình huống thót tim.',
      ],
     },
     {
      title: 'Hình tượng nhân vật xuất sắc trong phim Con Cám 2024',
      texts: [
        'Ngoài cốt truyện hấp dẫn, hình tượng nhân vật cũng chính là một trong những điểm thu hút khán giả vô cùng thích thú. Đặc biệt, những hình ảnh spoiler về “con cám” chính là một trong những điểm thu hút trên các sóng mạng xã hội. ',
        'Cám',
      ],
      image: cam
    },
    {
      texts: [
        'Diễn viên trẻ Lâm Mỹ Thanh sẽ là người đảm nhiệm vai trò nhân vật chính đóng xuyên suốt toàn bộ câu chuyện. Tuy có tuổi đời khá trẻ nhưng cô nang trước nay đã khá quen thuộc với khán giả màn ảnh rộng Việt Nam. Điển hình là nhiều nhân vật trong các bộ phim lớn như Nghề siêu dễ, Siêu trộm, Tôi thấy hoa vàng trên cỏ xanh, Tình đầu thơ ngây,... Đặc biệt hơn nữa cô nàng còn đã tham gia hai dự án kinh dị Đoạt Hồn và Bóng Đè đã làm nên tên tuổi  “ma nhí đáng sợ nhất màn ảnh Việt". ',
        'Cô nàng đã từng có chia sẻ cảm nghĩ khi nhận được vai diễn này:"Mình nghĩ Cám sẽ là vai diễn có nhiều sự đột phá nhất trong hành trình hoạt động nghệ thuật của mình. Từ trước đến nay, mọi người quen thấy mình đóng những vai hiền lành, dễ thương, nhiều cảm xúc. Mặc dù mình đã tham gia nhiều phim kinh dị nhưng Cám là vai diễn đầu tiên mình có nhiều sự đột phá và đất diễn hơn. Cám là một vai rất đặc biệt để mình có thể xem đây như một vai diễn đánh dấu sự trưởng thành trong sự nghiệp. Với Con Cám, mình nhận thấy sự trưởng thành trong cách diễn xuất, cách làm việc, mọi thứ đều được mình làm một cách kỹ càng và chỉn chu hơn so với những vai diễn khác mình tham gia".',
        'Tấm',
      ],
      image: rima
     },
         {
      texts: [
        'Rima Thanh Vy là nữ diễn viên trẻ đã khẳng định tài năng diễn xuất đa dạng qua các vai diễn ấn tượng. Từ cô gái có tâm lý phức tạp trong "Mười: Lời nguyền trở lại" đến "đả nữ" quyến rũ và quyết đoán trong "Thanh Sói", Rima luôn biết cách chinh phục khán giả.',
        'Trong dự án điện ảnh mới nhất "Con Cám", nữ diễn viên tiếp tục thử thách bản thân với một vai diễn đầy bất ngờ. Khác hẳn với hình tượng Tấm dịu dàng, thục nữ trong truyện cổ tích, Rima hứa hẹn sẽ mang đến một Tấm cá tính, mạnh mẽ và đầy bí ẩn. Điều này hứa hẹn sẽ tạo nên một "cú twist" thú vị cho câu chuyện cổ tích quen thuộc.',
        'Mẹ Cám'
      ],
            image: mecam
     },
     {
     texts: [
        'Một trong những vai diễn nhận được sự chú ý nhiều nhất của truyền thông mạng chính là vai mẹ kế. Thuý Diễm vừa trở lại màn ảnh sau 10 năm với một vai diễn đầy thử thách, đánh dấu cột mốc quan trọng trong sự nghiệp diễn xuất của cô. Theo chia sẻ của nữ diễn viên, vai diễn này là vai phản diện nặng ký nhất mà cô từng đảm nhận, với một nhân vật vừa ác độc vừa sắc sảo trong từng lời nói và hành động.',
        '“Điểm khác biệt so với các phiên bản Tấm Cám trước đây là nhân vật dì ghẻ của Diễm sẽ được khắc họa từ khi bà còn 18 tuổi, qua các giai đoạn khác nhau từ lúc Cám ra đời đến quá trình trưởng thành của Tấm Cám. Khán giả sẽ có cái nhìn sâu hơn về xuất thân và lối sống của nhân vật, tạo nên lý do cho sự tàn nhẫn và thâm độc của bà mẹ kế mà mọi người đã quen thuộc trong truyện cổ tích,” Thuý Diễm cho biết thêm.',
        'Đối với đạo diễn Trần Hữu Tấn, Thuý Diễm là lựa chọn không thể thay thế cho vai dì ghẻ. Anh chia sẻ rằng ngay từ lần gặp đầu tiên, anh đã biết cô chính là nhân vật mà ê-kíp đã tìm kiếm bấy lâu.',
        'Đạo diễn Trần Hữu Tấn chia sẻ: “Không chỉ sở hữu vẻ ngoài thu hút, Thuý Diễm còn toát lên nét sắc sảo, hoàn hảo cho vai diễn người mẹ kế mưu mô và thâm độc. Tôi đặc biệt ấn tượng với giọng nói của Thuý Diễm, vừa sắc bén lại dịu dàng, thể hiện rất rõ sự đanh đá của một phụ nữ phòng nhì, nhưng đồng thời cũng đầy quyền lực như một bà mẹ kế.”',
        'Bên cạnh Thuý Diễm, bộ phim còn có sự tham gia của các diễn viên nổi bật như Lâm Thanh Mỹ, Rima Thanh Vy, Quốc Cường và Hải Nam. Lâm Thanh Mỹ – người từng gây ấn tượng trong các dự án trước đó, sẽ thủ vai Cám, trong khi Rima Thanh Vy đảm nhận vai Tấm. Sự xuất hiện của NSƯT Hạnh Thúy, NSƯT Ngọc Hiệp và các diễn viên trẻ khác cũng góp phần tạo nên sự đa dạng và chiều sâu cho bộ phim.',
        'Đạo diễn Trần Hữu Tấn đã dành nhiều lời khen ngợi cho dàn diễn viên của mình, đặc biệt là sự hoá thân tuyệt vời của Thuý Diễm trong vai người mẹ kế thâm độc. Ông chia sẻ rằng, ngay từ lần gặp đầu tiên, anh đã nhận ra Thuý Diễm chính là lựa chọn hoàn hảo cho vai diễn này, với vẻ ngoài sắc sảo và khả năng diễn xuất ấn tượng.',
        'Phim Con Cám hứa hẹn sẽ mang đến cho khán giả một trải nghiệm mới mẻ với sự kết hợp giữa yếu tố cổ tích và kinh dị, cùng những màn trình diễn ấn tượng từ dàn diễn viên chất lượng. Đây không chỉ là một bộ phim giải trí, mà còn là một hành trình đầy cảm xúc và khám phá những khía cạnh sâu sắc hơn của câu chuyện Tấm Cám mà chúng ta vẫn quen thuộc.',
      ],
          
     },
  ]
  }
      ]
    }
  },
  computed: {
    news() {
      const slug = this.$route.params.slug
      return this.newsList.find(item => item.slug === slug)
    },
  }
}
</script>

<style scoped>

.detail-wrapper {
  background: #f2f2f2;
  padding: 40px 0;
}

.detail-container {
  width: 1000px;
  margin: auto;
  background: #fff;
  padding: 40px;
  border-radius: 12px;
}

.main-title {
  text-align: center;
  margin-bottom: 30px;
}

.movie-item {
  margin-bottom: 40px;
}

.movie-item h2 {
  margin-bottom: 10px;
}

.movie-item p {
  line-height: 1.6;
  margin-bottom: 10px;
}

.detail-img {
  width: 100%;
  margin-top: 15px;
  border-radius: 8px;
}

</style>